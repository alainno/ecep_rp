<?php namespace Ecep\Http\Controllers\Auth;

use Ecep\Helpers\HelperApp;
use Ecep\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EndpointController extends Controller
{
    private $request;
    private $error;

    public function __construct(Request $request)
    {

        $this->request = $request;
        $this->error = $this->request->get('error');
    }

    public function getOpAuth()
    {
        if (!$this->error) {
            $stateSession = $this->request->session()->get('state');
            $code = $this->request->get('code');
            $state = $this->request->get('state');
            if ($stateSession == $state) {
                $client = new Client();
                $client->setDefaultOption('verify', false);
                $tokenEndpoint = env('IDP_URL') . '/token';

                $request = $client->createRequest('POST', $tokenEndpoint, [
                    'body' => [
                        'grant_type' => 'authorization_code',
                        'code' => $code,
                        'redirect_uri' => HelperApp::baseUrl('/end-point/op-auth'),
                        'client_id' => '123456',
                        'client_secret' => '123'
                    ]
                ]);

                $response = json_decode($client->send($request)->getBody()->getContents());
                dd($response);
                $this->request->session()->put('access_token', $response->access_token);
                $this->request->session()->put('id_token', $response->id_token);

                return redirect(HelperApp::baseUrl('/auth/op-login'));
            } else {
                Log::error('State esperado: ' . $stateSession);
                Log::error('State recivido: ' . $state);
                return redirect()->to(HelperApp::baseUrl('/'));
            }
        } else {
            Log::error('Error params: ' . json_encode($this->request->all()));
            return redirect()->to(HelperApp::baseUrl('/'));
        }
    }
}
