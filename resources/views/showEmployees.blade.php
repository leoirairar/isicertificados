@extends('layouts.app')
 @section('content')
<div class="container">
@if (Auth::user()->role == 'S' || Auth::user()->role == 'M' || Auth::user()->role == 'A')
<div class="row">
        <div class="col-md-3 offset-md-9 col-sm-3">
            <a class="btn btn-success btn-block" href="{{ url('/employee') }}">
            Nuevo Empleado
            </a>
            <br>
        </div>
    </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="font-weight: bold">Empleados </div>
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <div class="card-body">
                    @if (Session::has('message'))
                        <div class="alert alert-success fade show">{{ Session::get('message') }}</div>
                    @endif
                    <table class="table table-striped table-hover" id="employeesTable">
                        <thead>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection @section('scripts')
<script src="{{ asset('js/datatables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/app/employee.js') }}"></script>
<script src="{{ asset('js/app/general.js') }}"></script>
@endsection
