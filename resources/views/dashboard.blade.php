@extends('app')

@section('content')
    <header class="z-depth-1">
        <div class="logo teal">
            <a href="#">ECEP</a>
        </div>
        <div class="nav-top">
            <ul class="list-unstyled nav-right">
                <li>
                    <a data-activates="dp_user" class="dropdown-button waves-effect btn btn-without-shadow btn-user">
                        <div class="chip">
                            {{ Session::get('names') }}
                        </div>
                    </a>
                </li>
            </ul>
        </div>
        <ul id="dp_user" class="dropdown-content">
            <li>
                <a href="#!">Mi Perfil</a>
            </li>
            <li class="divider"></li>
            <li>
                <a href="{{ pHelper::baseUrl('/auth/logout') }}">Salir</a>
            </li>
        </ul>
    </header>
    <div class="main-container">
        <div class="content-container">
            <div class="container">
                <div class="row">
                    <div class="col s12">
                        <?php
                        $localLabels = ['provider' => 'Proveedor: ', 'dni' => 'DNI: ', 'names' => 'Nombres: ', 'lastnames' => 'Apellidos: ',
                            'birthdate' => 'Fec. Nac.: ', 'gender' => 'Genero: ', 'country' => 'País: ',
                            'state' => 'Estado: ', 'city' => 'Lima: ', 'street' => 'Calle: ', 'email' => 'E-mail: '];
                        $data = json_decode(Session::get('data'), true);
                        ?>
                        <h1>BIENVENIDO {{ $data['names'] . ' ' . $data['lastnames'] }}</h1>

                        @foreach($data as $key => $value)
                            @if($value != '' && array_key_exists($key, $localLabels))
                                <p>{{ $localLabels[$key] }} <b>{{ $value }}</b></p>
                            @endif
                        @endforeach

                        <p>USER INFO</p>
                        @if($data['all'])
                            <pre>
                                <?php
                                echo print_r($data['all'], true);
                                ?>
                            </pre>
                        @endif

                        <p>ID TOKEN</p>
                        <p>
                            {{ trim(Session::get('id_token')) }}
                        </p>

                        @if(Session::get('refresh_token'))
                            <p>REFRESH TOKEN</p>
                            <p>
                                {{ trim(Session::get('refresh_token')) }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection