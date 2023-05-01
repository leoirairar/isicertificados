@extends('layouts.app')
 @section('content')
<div class="container">
@if (Auth::user()->role == 'S' || Auth::user()->role == 'M')
<div class="row">
        <div class="col-md-3 offset-md-6 col-sm-3">
            <a class="btn btn-success btn-block" href="{{ url('/course') }}">
            Crear Curso
            </a>
            <br>
        </div>  
        <div class="col-md-3 col-sm-3">
                <a class="btn btn-primary btn-block" href="{{ url('/courseProgramming') }}">
                Programar Curso
                </a>
                <br>
            </div>  
    </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="font-weight: bold">Cursos </div>
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <div class="card-body">
                    @if (Session::has('message'))
                        <div class="alert alert-success fade show">{{ Session::get('message') }}</div>
                    @endif
                    <table class="table table-striped table-hover">
                        <thead>
                            <th>id</th>
                            <th>Nombre</th>
                            <th>Codigo del curso</th>
                            <th>Prefijo</th>
                            <th>Fecha creación</th>
                            <th>Estado</th>
                            <th colspan="2">&nbsp;</th>
                        </thead>
                        <tbody>
                            @foreach ($courses as $course)
                            
                                <tr>
                                    <td>{{$course->id}}</td>
                                    <td>{{$course->name}}</td>
                                    <td>{{$course->course_code}}</td>
                                    <td>{{$course->prefix}}</td>
                                    <td>{{$course->created_at}}</td>
                                    <td>{{ ($course->deleted_at == null)?'Activo':'Inactivo' }}</td>
                                    @if (Auth::user()->role == 'S' || Auth::user()->role == 'M')
                                    <td width="10px">
                                        <a href="{{url('editCourse/'.$course->id)}}" class="btn btn-success">editar</a>
                                    </td>
                                        <td width="10px">
                                            <form action="{{url('deleteCourse/'.$course->id)}}" method="post">
                                                    
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger" style="width: 103px;" onclick="showAlert()" type="submit">
                                                    
                                                    @if ($course->deleted_at != null)
                                                    <a class="">Activar</a>
                                                    @else
                                                    <a class="">Desactivar</a>
                                                    @endif
                                                </button>
                                                
                                            </form>
                                            
                                        </td>   
                                    @endif
                                    
                                </tr>
                       
                            @endforeach 
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection @section('scripts')
<script src="{{ asset('js/app/general.js') }}"></script>
@endsection