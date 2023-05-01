<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ ltrim(asset('css/attendancePdf.css'), '/') }}" />
</head>
<body>
    <img id="imageBackground" src="{{asset('images/PLANTILLA CONSTANCIA.jpg')}}" alt="">
    
    <div id="userName"><strong>{{strtoupper($certificateEnrollment['name'].',')}}</strong> con cédula de ciudadania <strong>{{strtoupper($certificateEnrollment['identification'])}}</strong></div>
    <p id="attendance" >asistió al curso de:</p>
    <p id="course" >{{strtoupper($certificateEnrollment['course'])}}</p>
    <p id="duration"><span>({{strtoupper($certificateEnrollment['duration'])}} )</span></p>
    <p id="expeditionDate" >{{$literalExpeditionDate}}</p> 
    <p id="expeditionLiteralDate" >{{$expeditionLiteralDate}}</p> 
    <img id="signature" src="{{asset('images/FIRMA ALEXIS V.png')}}" alt=""> 
    <p id="instructor" >JOVAN ALEXIS VELEZ ZULUAGA</p>
    <p id="position" >REPRESENTANTE LEGAL</p>
</body>
</html>