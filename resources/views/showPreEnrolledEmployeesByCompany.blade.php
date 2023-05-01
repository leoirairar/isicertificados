@extends('layouts.app')
 @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="font-weight: bold">Empleados pre inscritos </div>
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <div class="card-body">
                    @if($companAdministrator != null)
                    <input type="hidden" name="adminCompanyId" id="adminCompanyId" value="{{$companAdministrator->user_id}}">
                    <div class=" d-flex flex-row ">
                        <div class="col-md-8 mt-4">
                            <span><h2><p class="font-weight-bold"></p></h2></span>
                        </div>
                    </div>
                    @else
                        <div class=" d-flex flex-row-reverse ">
                                <div class="col-md-4">
                                        <button type="button" onclick="" name="filter" id="filter" class="btn bbtn btn-primary">Filtrar</button>
                                </div>
                            <div class="col-md-8 ml-2">
                                <select class="form-control @error('company') is-invalid @enderror company" id="company" name="company"  required autocomplete="current-company">
                                    <option value="">Selecciona una opción</option>
                                    @foreach ($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->company_name}}</option> 
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-12 mt-5">
                            <table id="employeesPreEnrolled" class="table table-striped table-hover">
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
</div>
@endsection 

@section('scripts')
<script src="{{ asset('js/datatables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/app/preEnrolledEmployeesByCompany.js') }}"></script>
@endsection