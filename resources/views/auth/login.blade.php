@extends('app')

@section('content')
    <div class="container">
        <div class="center-align row">
            <div class="col s12 m6 l4 offset-m3 offset-l4 container-login">
                <h1>ECEP - RP</h1>

                <a href="{{ $loginCert }}" class="login-dnie">Ingrese con su DNIe</a>
                <a href="{{ $loginCertToken }}" class="login-token">Ingrese con su DNIe/Token</a>
                <a href="{{ $loginPass }}" class="login-password">Ingrese con Usuario y Contraseña</a>
            </div>
        </div>
    </div>
@endsection