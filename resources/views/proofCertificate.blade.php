<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link href="css/app.css" rel="stylesheet">
    <link href="css/theme.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
    .btn-primary {
        color: #fff;
        background-color: #3490dc;
        border-color: #3490dc;
    }

    html
    {
       font-family: Poppins, sans-serif !important;
    }
    .finishTable
    {
        font-family: Poppins, sans-serif !important;
    }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="font-weight: bold; font-family:Poppins, sans-serif;font-size: 12px;">Descargar certificado de asistencia</div>
                <div class="card-body">
                    <div class="form-group row">
                        <label for="identification" style="font-family:Poppins, sans-serif;font-weight: 400!important; font-size: small;" class="col-md-4 col-form-label text-md-right">{{ __('Ingresar la cedula') }}</label>
                        <div class="col-md-4">
                            <input id="identification" type="text" class="form-control" name="identification" value="{{('')}}" required autocomplete="identification" autofocus>
                            
                        </div>
                        <div>
                            <button class="btn btn-primary" id="btnIdentification">{{('Consultar')}}</button>
                        </div>
                    </div>
                    <div id="container">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="js/app.js"></script>
<script src="https://code.jquery.com/jquery-2.2.4.js"  crossorigin="anonymous"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script> --}}
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="js/datatables.min.js"></script>
<script src="js/dataTables.bootstrap4.min.js"></script>
<script src="js/app/attendanceCertificate.js"></script> 
</body>
</html>