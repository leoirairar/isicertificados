<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    {{-- <link rel="stylesheet" href="{{ ltrim(asset('css/newPdfCerticate.css'), '/') }}" /> --}}
    <style>
        @page {
            margin: 0px;
            /* size: a4 landscape;  */
        }

        body {
            /* width: 1122px; */
            /* height: 791px; */
            font-size: 125%;
            font-family: Calibri, sans-serif;
            color: #595b61;
            margin: 0px;
        }

        img {
            max-width: 100%;
            margin: 0;
        }

        #imageBackground {
            position: absolute;
        }

        #userInfoP {
            position: absolute;
            top: 230px;
            width: 95%;
            text-align: center;
            font-size: 18px;

        }

        #content {
            position: absolute;
            top: 315px;
            width: 80%;
        }

        #course {
            position: relative;
            top: 295px;
            text-align: center;
            color: #ff522e;
            text-decoration: #ff522e;
            font-weight: bold;
            font-size: 32px;
            margin-left: 70px;
        }

        #duration {
            position: absolute;
            top: 335px;
        }

        #expeditionDate {
            position: absolute;
            top: 345px;
        }

        #literalExpedition {
            position: absolute;
            top: 560px;
            width: 80%;
            text-align: center;
            font-size: smaller;
        }

        #template p {
            left: 55%;
            transform: translateX(-50%);
        }

        #certificateCode {
            position: absolute;
            top: 215px;
            width: 99%;
            font-size: 15px;
            left: 45px;
        }

        #supervisorName {
            position: absolute;
            bottom: 265px;
            left: 275px;
            text-align: center;
            font-weight: bold;
            font-size: 100%;
        }

        #supervisorLicenseNumber {
            position: absolute;
            bottom: 230px;
            left: 275px;
            text-align: center;
            font-size: 100%;
        }

        #supervisorPosition {
            position: absolute;
            bottom: 248px;
            left: 275px;
            text-align: center;
            font-size: 100%;
        }

        #instructorName {
            position: absolute;
            bottom: 265px;
            left: 700px;
            text-align: center;
            font-weight: bold;
            font-size: 100%;
        }

        #instructorLicenseNumber {
            position: absolute;
            bottom: 230px;
            left: 700px;
            text-align: center;
            font-size: 100%;
        }

        #instructorPosition {
            position: absolute;
            bottom: 248px;
            left: 700px;
            text-align: center;
            font-size: 100%;
        }

        #signatureSupervisor {
            position: fixed;
            bottom: 375px;
            left: 290px;
            width: 180px;
        }

        #signatureInstructor {
            position: fixed;
            bottom: 375px;
            left: 730px;
            width: 180px;
        }

        #aprobeText {
            position: absolute;
            top: 270px;
            left: 120px;
            width: 400%;
            font-size: 18px;
        }

        #aprobeTextEspecial {
            position: absolute;
            top: 270px;
            left: 410px;
            width: 400%;
        }
    </style>
</head>

<body>
    <div id="template">
        <img id="imageBackground" src="{{public_path().'/images/baseISI.png' }}" alt="">
        <div id="certificateCode">
            <span>{{ 'CÓDIGO ISI-' . $certificateEnrollment->certificate->isi_code_certification }}</span>
        </div>
        @if ($certificateEnrollment->courseProgramming->course->type == '1')
            <div style="position:fixed;margin-right: 2%;">
                <p id="userInfoP"><span><strong>{{ Str::upper($certificateEnrollment->employee->user->name) }}
                            {{ Str::upper($certificateEnrollment->employee->user->last_name) }}</strong>, con
                        {{ $tipoDocumento }} <strong>{{ $certificateEnrollment->employee->user->identification_number }}
                        </strong> con ARL <strong>{{ $certificateEnrollment->employee->company->arl }}</strong></span>
                </p>
            </div>

            <div id="aprobeText"><span>Aprobó y Recibió satisfactoriamente el certificado de capacitación y
                    entrenamiento para trabajo en alturas como:</span></div>
        @else
            <p id="userInfoP"><span><strong>{{ Str::upper($certificateEnrollment->employee->user->name) }}
                        {{ Str::upper($certificateEnrollment->employee->user->last_name) }}</strong>, con
                    {{ $tipoDocumento }} <strong>{{ $certificateEnrollment->employee->user->identification_number }}
            </p>
            <div id="aprobeTextEspecial"><span>Aprobó satisfactoriamente la asistencia a :</span></div>
        @endif
        <p id="content"></p>
        <div id="course">
            <strong><span>{{ Str::upper($certificateEnrollment->courseProgramming->course->course_code) }}</span><strong>
        </div>
        <p id="duration"><span>({{ $certificateEnrollment->courseProgramming->duration }} )</span></p>
        <p id="expeditionDate"><span>{{ $expeditionDateString }}</span></p>
        <p id="literalExpedition"><span>{{ $literalExpeditionDate }}</span></p>
        @foreach ($certificateEnrollment->courseProgramming->courseInstructor as $courseInstructor)
            @if ($courseInstructor->supervisor == 1)
                <img id="signatureSupervisor" src="{{ public_path().'/storage/'. $courseInstructor->instructor->sign_name }}"
                    alt="">
                <div id="supervisorName">
                    <span>{{ $courseInstructor->instructor->user->name . ' ' . $courseInstructor->instructor->user->last_name }}</span>
                </div>
                @if ($courseInstructor->instructor_id == 9)
                    <div id="supervisorPosition"><span>{{ $courseInstructor->instructor->position }}</span></div>
                @else
                    <div id="supervisorPosition"><span>DIRECTOR OPERATIVO</span></div>
                @endif
                <div id="supervisorLicenseNumber"><span>LIC-SST
                        {{ $courseInstructor->instructor->license_number }}</span></div>
            @endif
            @if ($courseInstructor->supervisor == 0)
                <img id="signatureInstructor" src="{{ public_path().'/storage/'. $courseInstructor->instructor->sign_name }}"
                    alt="">
                <div id="instructorName">
                    <span>{{ $courseInstructor->instructor->user->name . ' ' . $courseInstructor->instructor->user->last_name }}</span>
                </div>
                <div id="instructorPosition"><span>ENTRENADOR DE TSA</span></div>
                <div id="instructorLicenseNumber"><span>LIC-SST
                        {{ $courseInstructor->instructor->license_number }}</span></div>
            @endif
        @endforeach

    </div>
</body>

</html>
