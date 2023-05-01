@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="font-weight: bold">Empleado</div>
                    <div class="card-body">
                                        @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <input id="identification" type="text" class="form-control " name="identification"
                                        value="" required autocomplete="identification" autofocus>
                                </div>
                                <div class="col-md-6">
                                    <button class="btn btn-primary" id="identificationButton">Consultar</button>
                                </div>
                            </div>
                            <div class="row">
                                @if ($errors->any())
                                    <h4>{{ $errors->first() }}</h4>
                                @endif
                            </div>
                            
                            <div class="row mt-5">
                                <div class="" id="employeeInformation">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/app/employee-cedula.js') }}"></script>
@endsection
