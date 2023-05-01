@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow ">
                <div class="card-header" style="font-weight: bold">{{$company->company_name}}</div>
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <div class="card-body">
                    <div class="py-5 text-center">
                        <h1>{{$company->company_name}}</h1>
                    </div>
                    <div class="row">
                        <div class="col-md-8 order-md-1 pl-5">
                            <h4 data-type="header" class="d-flex justify-content-between align-items-center mb-3">
                                <span>Datos de la empresa</span>
                            </h4>
                            <div data-type="default" class="row">
                                <div data-type="default" class="col-md-6 mb-3">
                                    <label for="firstName">Nombre</label>
                                    <input data-type="default" type="text" id="firstName" placeholder="" readonly value="{{$company->company_name}}" required="" class="form-control">
                                    <input id="company_id" name="company_id" type="hidden" value="{{$company->id}}">
                                </div>
                                <div data-type="default" class="col-md-6 mb-3">
                                    <label for="lastName">Nit</label>
                                    <input data-type="default" type="text" id="lastName" placeholder="" readonly value="{{$company->nit}}" required="" class="form-control">
                                </div>
                            </div>
                            <div data-type="default" class="row">
                                <div data-type="default" class="col-md-6 mb-3">
                                    <label for="email">Correo electrónico de contacto</label>
                                    <input data-type="default" type="text" id="email" placeholder="" readonly value="{{$company->email}}" required="" class="form-control">
                                </div>
                                <div data-type="default" class="col-md-6 mb-3">
                                    <label for="lastName">Numero de telefono de contacto</label>
                                    <input data-type="default" type="text" id="lastName" placeholder="" readonly value="{{$company->phone_number}}" required="" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-11 pt-5 pl-5 pb-5">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="employees-tab" data-toggle="tab" href="#employees" role="tab" aria-controls="employees" aria-selected="true">Empleados</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="preEnrolledEmployees-tab" data-toggle="tab" href="#preEnrolledEmployees" role="tab" aria-controls="preEnrolledEmployees" aria-selected="false">Empleados pre-inscritos a un curso</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="enrolledEmployees-tab" data-toggle="tab" href="#enrolledEmployees" role="tab" aria-controls="enrolledEmployees" aria-selected="false">Empleados inscritos a cursos</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="employees" role="tabpanel" aria-labelledby="employees-tab">
                                    <div>
                                        <table class="table">
                                            <thead>
                                                <th>Nombre</th>
                                                <th>Apellidos</th>
                                                <th>Teléfono</th>
                                                <th>Correo Electrónico</th>
                                                <th colspan="2"></th>
                                            </thead>
                                            <tbody>
                                                @foreach ($company->employees as $employee)
                                                <tr>
                                                    <td>{{$employee->user->name}}</td>
                                                    <td>{{$employee->user->last_name}}</td>
                                                    <td>{{$employee->user->phone_number}}</td>
                                                    <td>{{$employee->user->email}}</td>
                                                    <td width="10px">
                                                        <a href="{{url('editEmployee/'.$employee->id)}}" class="btn btn-success">editar</a>
                                                    </td>
                                                    <td width="150px">
                                                        {{-- <a href=""  class="btn btn-success">Asignar a curso</a> --}}
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                                <div class="tab-pane fade" id="preEnrolledEmployees" role="tabpanel" aria-labelledby="preEnrolledEmployees-tab">
                                    <div class="row">
                                        <div class="col-md-12 mt-5">
                                            <table class="table table-striped table-hover" id="employeesPreEnrolled">
                                                <thead>
                                                    <th>Apellidos</th>
                                                    <th>Teléfono</th>
                                                    <th>Correo Electrónico</th>
                                                    <th colspan="2">&nbsp;</th>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                         </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="enrolledEmployees" role="tabpanel" aria-labelledby="enrolledEmployees-tab">
                                    <div class="row">
                                        <div class="col-md-12 mt-5">
                                            <table class="table table-striped table-hover" id="employeesEnrolled">
                                                <thead>
                                                <tr></tr>
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
                </div>
                <div class="card-footer d-flex flex-row-reverse">
                    <a class="btn btn-primary ml-2" href="{{ url('/getCompanies') }}" role="button">Regresar</a>
                    <a class="btn btn-primary ml-2" href="{{ url('/employee') }}" role="button">Agregar empleado</a>
                    <a class="btn btn-primary " href="{{url('getCourseAssignment/'.$company->id)}}" role="button">Asignar a curso</a>
                </div>
            </div>
        </div>
    </div>
    @endsection @section('scripts')
    <script src="{{ asset('js/datatables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/app/general.js') }}"></script>
    <script src="{{ asset('js/app/comapanyDetailTables.js') }}"></script>
    @endsection