<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="{{ ltrim(asset('css/pdf.css'), '/') }}" />
</head>
<body>
    <div id="template" >
        <img id="imageBackground" src="{{asset('images/baseISI.png')}}" alt="">
        <div id="certificateCode"><span>{{'CÓDIGO ISI-'.$certificateEnrollment->certificate->isi_code_certification}}</span></div>
        <p id="userInfoP"><span><strong>{{Str::upper($certificateEnrollment->employee->user->name)}} {{Str::upper($certificateEnrollment->employee->user->last_name)}}</strong>, con {{$tipoDocumento}} <strong>{{$certificateEnrollment->employee->user->identification_number}} </strong></span></p>
        <div id="aprobeText"><span>cursó y aprobó satisfactoriamente la certificación y entrenamiento para Trabajo seguro en Alturas como:</span></div>
        <p id="content"></p>
        <div id="course"><strong><span>{{Str::upper($certificateEnrollment->courseProgramming->course->course_code)}}</span><strong></div>
        <p id="duration"><span>({{$certificateEnrollment->courseProgramming->duration}} )</span></p>
        <p id="expeditionDate"><span>{{$expeditionDateString}}</span></p>
        <p id="literalExpedition"><span>{{$literalExpeditionDate}}</span></p>
        @foreach ($certificateEnrollment->courseProgramming->courseInstructor as $courseInstructor)
         @if ($courseInstructor->supervisor == 1)
            <img id="signatureSupervisor" src="{{asset('storage/'.$courseInstructor->instructor->sign_name)}}" alt="">
            <div id="supervisorName"><span>{{$courseInstructor->instructor->user->name.' '.$courseInstructor->instructor->user->last_name}}</span></div>
            @if ($courseInstructor->instructor_id == 9)
                <div id="supervisorPosition"><span>{{$courseInstructor->instructor->position}}</span></div>                
            @else
                <div id="supervisorPosition"><span>DIRECTOR OPERATIVO</span></div>
            @endif            
            <div id="supervisorLicenseNumber"><span>LIC-SST {{$courseInstructor->instructor->license_number}}</span></div>
         @endif
         @if ($courseInstructor->supervisor == 0)
            <img id="signatureInstructor" src="{{asset('storage/'.$courseInstructor->instructor->sign_name)}}" alt="">
            <div id="instructorName"><span>{{$courseInstructor->instructor->user->name.' '.$courseInstructor->instructor->user->last_name}}</span></div>
            <div id="instructorPosition"><span>ENTRENADOR DE TSA</span></div>
            <div id="instructorLicenseNumber"><span>LIC-SST {{$courseInstructor->instructor->license_number}}</span></div>            
         @endif            
        @endforeach
        
    </div></body></html>