<!DOCTYPE HTML>
<!--[if lt IE 8]>
<html class="no-js lt-ie8" data-ng-app="ecep"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" data-ng-app="ecep"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv='X-UA-Compatible' content='IE=edge'/>
    <title>ECEP RP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <link type="text/css" rel="stylesheet" media="screen,projection"
          href="{{ pHelper::baseUrl('/js/libs/materialize/dist/css/materialize.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ pHelper::baseUrl('/css/main.css') }}">
    <link rel="shortcut icon" href="{{ pHelper::baseUrl('/img/icon.png') }}">
</head>
<body>
<!--[if lt IE 9]>
<div class="lt-ie9-bg">
    <p class="browsehappy">Estas usando un navegador <strong>muy antiguo</strong>
        <a href="http://browsehappy.com/">actualizate</a>, vive una mejor experiencia y se feliz :D</p>
</div>
<![endif]-->

<div class="progress hide">
    <div class="indeterminate green"></div>
</div>

@yield('content')

<script src="{{ pHelper::baseUrl('/js/libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ pHelper::baseUrl('/js/libs/materialize/dist/js/materialize.min.js') }}"></script>
<script src="{{ pHelper::baseUrl('/js/libs/angular/angular.min.js') }}"></script>
<script src="{{ pHelper::baseUrl('/js/app/app.js') }}"></script>
@yield('scripts')
</body>
</html>
