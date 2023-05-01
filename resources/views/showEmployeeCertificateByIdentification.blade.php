@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="font-weight: bold">Consultar certificado por cedula.</div>
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <input id="identification" type="text" class="form-control " name="identification"
                                    value="" required autocomplete="identification" autofocus>
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-primary" id="identificationButton">Consultar</button>
                            </div>
                        </div>
                        <div class="">
                            <div class="row">
                                <div class="col-md-12 mt-5">
                                    <table class="table table-striped table-hover" id="employeeEnrollmentInformation">
                                            <thead>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                            </div>
                        </div>
                        {{-- <div class="row" >
                            <div class="table-responsive mt-5">
                            <table class="table table-striped table-hover" id="employeeEnrollmentInformation" style="width:100%!important">
                                <thead>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/datatables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/app/userCertificate.js') }}"></script>
@endsection
