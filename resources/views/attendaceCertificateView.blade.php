@extends('layouts.app')

@section('content')
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" style="font-weight: bold">Descargar certificado de asistencia</div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="identification" class="col-md-4 col-form-label text-md-right">{{ __('Ingresar la cedula') }}</label>
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
@endsection
@section('scripts')
<script src="{{ asset('js/app/attendanceCertificate.js') }}"></script>
@endsection