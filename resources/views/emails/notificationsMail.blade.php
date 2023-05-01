<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>

    <div style="width: 520px;display: block;margin: auto;text-align: center;font-family: helvetica, arial, sans;background-color: #eee;padding: 25px;border-radius: 5px;">
        <div><img src="http://formacion.isiseguridadindustrial.com/images/logo.jpg" style="width: 100%;"></div>
        <h1>Creacion de usuario administrador</h1>
        @if (isset($datas->url))
        <p>{{$datas->message}}</p>
        <div style="margin: 20px;"><a href="http://formacion.isiseguridadindustrial.com/" style="background-color: #ff5e01;color: white;text-decoration: none;padding: 5px 15px;border-radius: 15px;">Click Para ingresar</a></div>
        <div>usuario: <b>{{'Usuario: '.$datas->user}}</b></div>
        <div>Contraseña <b>{{'Contraseña: '.$datas->password}}</b></div>
        @else
        <p>{{$datas->message}}</p>
        @endif
    </div>
</body>

</html>