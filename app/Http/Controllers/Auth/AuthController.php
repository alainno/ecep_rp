<?php namespace Ecep\Http\Controllers\Auth;

use Ecep\Helpers\HelperApp;
use Ecep\Http\Controllers\Controller;
use Facebook\Facebook;
use GuzzleHttp\Client;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use Illuminate\Auth\GenericUser;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\Debug\Exception\FatalErrorException;

class AuthController extends Controller
{
    /**
     * The Guard implementation.
     *
     * @var \Illuminate\Contracts\Auth\Guard
     */
    protected $auth;
    protected $request;

    public function __construct(Guard $auth, Request $request)
    {
        $this->auth = $auth;
        $this->request = $request;

        $this->middleware('guest', ['except' => ['getLogout', 'postLogin']]);
    }

    public function getLogin()
    {
        $state = bin2hex(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM));

        /////////CERTIFICATE DNIe//////////
        $params = [
            'response_type' => 'code',
            'client_id' => 'RvTnumo8EVzsrQmPgcqBnA',
            'redirect_uri' => HelperApp::baseUrl('/end-point/op-auth'),
            'state' => $state,
            'scope' => 'openid profile email address phone',
            'acr_values' => 'dnie'
        ];

        $this->request->session()->put('state', $state);
        $loginCert = env('IDP_URL') . '/auth?' . http_build_query($params);

        /////////CERTIFICATE DNIe AND TOKEN//////////
        $params = [
            'response_type' => 'code',
            'client_id' => 'RvTnumo8EVzsrQmPgcqBnA',
            'redirect_uri' => HelperApp::baseUrl('/end-point/op-auth'),
            'state' => $state,
            'scope' => 'openid profile email address phone',
            'acr_values' => 'dnie_token'
        ];

        $this->request->session()->put('state', $state);
        $loginCertToken = env('IDP_URL') . '/auth?' . http_build_query($params);

        /////////USER AND PASSWORD//////////	
        $params = [
            'response_type' => 'code',
            'client_id' => 'RvTnumo8EVzsrQmPgcqBnA',
            'redirect_uri' => HelperApp::baseUrl('/end-point/op-auth'),
            'state' => $state,
            'scope' => 'openid profile email address phone'
        ];

        $this->request->session()->put('state', $state);
        $loginPass = env('IDP_URL') . '/auth?' . http_build_query($params);


        return view('auth.login')
            ->with('loginCert', $loginCert)
            ->with('loginCertToken', $loginCertToken)
            ->with('loginPass', $loginPass);
    }

    public function getOpLogin()
    {
        $accessToken = $this->request->session()->get('access_token');
        $idToken = $this->request->session()->pull('id_token');

        $client = new Client();
        $client->setDefaultOption('verify', false);

        $uInfoEndpoint = env('IDP_URL') . '/userinfo';

        $request = $client->createRequest('GET', $uInfoEndpoint, [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken
            ]
        ]);

        $response = json_decode($client->send($request)->getBody()->getContents(), true);
        $logoutEndPoint = env('IDP_URL') . "/endsession";
        $params = [
            'post_logout_redirect_uri' => HelperApp::baseUrl('/'),
            'id_token_hint' => $idToken
        ];

        $idpLogOut = $logoutEndPoint . '?' . http_build_query($params);
        $data = [
            'provider' => 'RENIEC IDaaS',
            'access_token' => $accessToken,
            'auth_id' => $response['sub'],
            'names' => array_key_exists('given_name', $response) ? $response['given_name'] : null,
            'lastnames' => array_key_exists('family_name', $response) ? $response['family_name'] : null,
            'country' => array_key_exists('zoneinfo', $response) ? $response['zoneinfo'] : null,
            'city' => array_key_exists('zoneinfo', $response) ? $response['zoneinfo'] : null,
            'email' => array_key_exists('email', $response) ? $response['email'] : null,
            'all' => $response
        ];

        $urlReturn = $this->loginProvider($data, $idToken, $idpLogOut);
        return redirect($urlReturn);
    }

    public function loginProvider($data, $idToken, $idpLogOut = null)
    {
        Session::flush();

        $this->request->session()->put('user', true);
        $this->request->session()->put('names', $data['names']);
        $this->request->session()->put('data', json_encode($data));
        $this->request->session()->put('id_token', $idToken);

        if ($idpLogOut) {
            $this->request->session()->put('idpLogout', $idpLogOut);
        }

        return HelperApp::baseUrl('/admin');
    }

    public function redirectPath()
    {
        if (property_exists($this, 'redirectPath')) {
            return $this->redirectPath;
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : HelperApp::baseUrl('/admin');
    }

    public function loginPath()
    {
        return property_exists($this, 'loginPath') ? $this->loginPath : '/';
    }

    public function getLogout()
    {
        $idpLogout = $this->request->session()->pull('idpLogout');

        Session::flush();

        if ($idpLogout) {
            return redirect()->to($idpLogout);
        } else {
            return redirect()->to(HelperApp::baseUrl('/'));
        }
    }
}
