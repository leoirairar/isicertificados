@extends('layouts.app')

@section('content')
<div class="container">
@if (Auth::user()->role == 'S' || Auth::user()->role == 'M')
    <div class="row justify-content-center">
        <div class="col-lg-4">
            <div class="card">
                <div class="au-card-title" style="background-image:url('images/bg-title-01.jpg');">
                    <div class="bg-overlay bg-overlay--orange"></div>
                    <h3>
                        Empresa</h3>
                </div>
                <div class="card-body">
                    <div class="card-title mb-3">
                        <p>Permite crear una nueva empresa cliente</p>
                        <a class="btn btn-success btn-lg btn-block" href="{{ url('/company') }}">
                            Crear empresa
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="au-card-title" style="background-image:url('images/bg-title-01.jpg');">
                    <div class="bg-overlay bg-overlay--orange"></div>
                    <h3>
                        Administrador de Empresa</h3>
                </div>
                <div class="card-body">
                    <div class="card-title mb-3">
                        <p>Permite crear una persona a cargo de una empresa</p>
                        <a class="btn btn-success btn-lg btn-block" href="{{ url('/administrator') }}">
                            Crear Administrador
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="au-card-title" style="background-image:url('images/bg-title-01.jpg');">
                    <div class="bg-overlay bg-overlay--orange"></div>
                    <h3>
                        Crear Empleado</h3>
                </div>
                <div class="card-body">
                    <div class="card-title mb-3">
                        <p>Permite registrar una persona como empleado</p>
                        <a class="btn btn-success btn-lg btn-block" href="{{ url('/employee') }}">
                            Crear Empleado
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-4">
            <div class="card">
                <div class="au-card-title" style="background-image:url('images/bg-title-01.jpg');">
                    <div class="bg-overlay bg-overlay--orange"></div>
                    <h3>
                        Empleados Inscritos</h3>
                </div>
                <div class="card-body">
                    <div class="card-title mb-3">
                        <p>Aprobar empleados preinscritos a un curso</p>
                        <a class="btn btn-success btn-lg btn-block" href="{{ url('/EnrolledEmployees') }}">
                            Aprobar Empleados
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="au-card-title" style="background-image:url('images/bg-title-01.jpg');">
                    <div class="bg-overlay bg-overlay--orange"></div>
                    <h3>
                        Cursos Programados</h3>
                </div>
                <div class="card-body">
                    <div class="card-title mb-3">
                        <p>Permite ver los cursos programados vigentes</p>
                        <a class="btn btn-success btn-lg btn-block" href="{{ url('/getCourseProgramming') }}">
                            Ver cursos programados
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="au-card-title" style="background-image:url('images/bg-title-01.jpg');">
                    <div class="bg-overlay bg-overlay--orange"></div>
                    <h3>
                        Finalizar Curso</h3>
                </div>
                <div class="card-body">
                    <div class="card-title mb-3">
                        <p>Finaliza un curso que esté activo</p>
                        <a class="btn btn-success btn-lg btn-block" href="{{ url('/getViewCourseFinalization') }}">
                            Finalizar curso
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-4">
            <div class="card">
                <div class="au-card-title" style="background-image:url('images/bg-title-01.jpg');">
                    <div class="bg-overlay bg-overlay--orange"></div>
                    <h3>
                        Generar Certificados</h3>
                </div>
                <div class="card-body">
                    <div class="card-title mb-3">
                        <p>Consulte y genere certificados por curso</p>
                        <a class="btn btn-success btn-lg btn-block" href="{{ url('/getCertificates') }}">
                            Generar certificados
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="au-card-title" style="background-image:url('images/bg-title-01.jpg');">
                    <div class="bg-overlay bg-overlay--orange"></div>
                    <h3>
                        Exportar Datos al Ministerio</h3>
                </div>
                <div class="card-body">
                    <div class="card-title mb-3">
                        <p>Genera documento excel para subir al ministerio</p>
                        <a class="btn btn-success btn-lg btn-block" href="{{ url('/ministryDocument') }}">
                            Descargar archivo ministerio
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="au-card-title" style="background-image:url('images/bg-title-01.jpg');">
                    <div class="bg-overlay bg-overlay--orange"></div>
                    <h3>
                        Histórico de Inscripción</h3>
                </div>
                <div class="card-body">
                    <div class="card-title mb-3">
                        <p>Histórico de los empleados inscritos en la plataforma</p>
                        <a class="btn btn-success btn-lg btn-block" href="{{ url('/enrollmentHistory') }}">
                            Descargar Archivo
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @if (Auth::user()->role == 'A' || Auth::user()->role == 'M' || Auth::user()->role == 'S')
    <div class="row justify-content-center mb-5" id="banner">
       
        <img src="{{'banner/'.$fileName}}" class="img-fluid" >

    </div>
    @endif
    @if (Auth::user()->role == 'A')
    <div class="row justify-content-center">
        <div class="col-lg-4">
            <div class="card">
                <div class="au-card-title" style="background-image:url('images/bg-title-01.jpg');">
                    <div class="bg-overlay bg-overlay--orange"></div>
                    <h3>
                        Nuevo Empleado</h3>
                </div>
                <div class="card-body">
                    <div class="card-title mb-3">
                        <p>Inscribir la información de un empleado que va a realizar un curso</p>
                        <a class="btn btn-success btn-lg btn-block" href="{{ url('/employee') }}">
                            Nuevo Empleado
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="au-card-title" style="background-image:url('images/bg-title-01.jpg');">
                    <div class="bg-overlay bg-overlay--orange"></div>
                    <h3>
                        Inscribir empleado</h3>
                </div>
                <div class="card-body">
                    <div class="card-title mb-3">
                        <p>Inscribir un empleado existente a un curso de ISI</p>
                        <a class="btn btn-success btn-lg btn-block" href="{{ url('/getCourseAssignment') }}">
                            Preiniscribir empleado
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="au-card-title" style="background-image:url('images/bg-title-01.jpg');">
                    <div class="bg-overlay bg-overlay--orange"></div>
                    <h3>
                        Actualizar Documentación</h3>
                </div>
                <div class="card-body">
                    <div class="card-title mb-3">
                        <p>Actualiza los documentos de los empleados preinscritos a un curso</p>
                        <a class="btn btn-success btn-lg btn-block" href="{{ url('/preEnrolledEmployeesView') }}">
                            Actualizar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-4">
            <div class="card">
                <div class="au-card-title" style="background-image:url('images/bg-title-01.jpg');">
                    <div class="bg-overlay bg-overlay--orange"></div>
                    <h3>
                        Generar Certificados por cédula</h3>
                </div>
                <div class="card-body">
                    <div class="card-title mb-3">
                        <p>Consultar y descargar los certificados por cedula</p>
                        <a class="btn btn-success btn-lg btn-block" href="{{ url('/getEmployeeCertificates') }}">
                            Generar certificados
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="au-card-title" style="background-image:url('images/bg-title-01.jpg');">
                    <div class="bg-overlay bg-overlay--orange"></div>
                    <h3>
                        Consultar Empleados</h3>
                </div>
                <div class="card-body">
                    <div class="card-title mb-3">
                        <p>Permite ver todos los empleados qe perteneces a su organización</p>
                        <a class="btn btn-success btn-lg btn-block" href="{{ url('/getEmployee') }}">
                            Ver empleados
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endif
</div>
@endsection
