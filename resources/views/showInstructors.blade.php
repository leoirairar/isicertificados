@extends('layouts.app')
 @section('content')
<div class="container">
@if (Auth::user()->role == 'S' || Auth::user()->role == 'M')
<div class="row">
        <div class="col-md-3 offset-md-9 col-sm-3">
            <a class="btn btn-success btn-block" href="{{ url('/instructor') }}">
            Crear Instructor
            </a>
            <br>
        </div>  
    </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="font-weight: bold">Instructores </div>

                <div class="card-body">
                    @if (Session::has('message'))
                        <div class="alert alert-success fade show">{{ Session::get('message') }}</div>
                    @endif
                    <table class="table table-striped table-hover">
                        <thead>
                            <th>id</th>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>Estudios</th>
                            <th colspan="2">&nbsp;</th>
                        </thead>
                        <tbody>
                            @foreach ($instructors as $instructor)
                            
                                <tr>@isset($instructor->user)
                                    <td>{{$instructor->id}}</td>
                                    <td>{{$instructor->user->name}} {{$instructor->user->last_name}}</td>
                                    <td>{{$instructor->user->phone_number}}</td>
                                    @endisset
                                    <td>
                                    @foreach ($instructor->academicDegrees as $academicDegree)
                                        {{$academicDegree->name.' | '}} 
                                    @endforeach
                                     </td>   
                                    <td width="10px">
                                        <a href="{{url('editInstructor/'.$instructor->id)}}" class="btn btn-success">editar</a>
                                    </td>
                                    @if (Auth::user()->role == 'S' || Auth::user()->role == 'M')
                                        <td width="10px">
                                            <form action="{{url('deleteInstructor/'.$instructor->id)}}" method="post">
                                                    
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger" style="width: 103px;"  onclick="showAlert()" type="submit">
                                                    @if ($instructor->deleted_at != null)
                                                    <i class="fa fa-undo"></i>
                                                    @else
                                                    <i class="fa fa-trash-o"></i>
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
@endsection
@section('scripts')
<script src="{{ asset('js/app/general.js') }}"></script>
@endsection