@extends('layouts.app')
 @section('content')
<div class="container">
@if (Auth::user()->role == 'S' || Auth::user()->role == 'M')
<div class="row">
        <div class="col-md-3 offset-md-9 col-sm-3">
            <a class="btn btn-success btn-block" href="{{ url('/administrator') }}">
            Crear Administrador
            </a>
            <br>
        </div>  
    </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="font-weight: bold">Administrador empresa </div>
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <div class="card-body">
                    @if (Session::has('message'))
                        <div class="alert alert-success fade show">{{ Session::get('message') }}</div>
                    @endif
                    <table class="table table-striped table-hover">
                        <thead>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Teléfono</th>
                            <th>Empresa</th>
                            <th>cargo</th>
                            <th colspan="2">&nbsp;</th>
                        </thead>
                        <tbody>
                            @foreach ($comAdmin as $admin)
                            @if ($admin->role != 'M')                           
                            <tr>
                                <td>{{$admin->name}} {{$admin->last_name}}</td>
                                <td>{{$admin->email}}</td>
                                <td>{{$admin->phone_number}}</td>
                                <td>
                                @foreach ($admin->companyAdministrator as $companyAdmin)
                                    @isset($companyAdmin->company->company_name)
                                        {{$companyAdmin->company->company_name.','}}
                                    @endisset
                                @endforeach
                                </td>
                                <td>{{$admin->position}}</td>
                                <td width="10px">
                                    <a href="{{url('editCompanyAdministrator/'.$admin->id)}}" class="btn btn-success">editar</a>
                                </td>
                                @if (Auth::user()->role == 'S' || Auth::user()->role == 'M')
                                    <td width="10px">
                                        <form action="{{url('deleteCompanyAdministrator/'.$admin->id)}}" method="post">
                                                
                                                @csrf
                                                @method('DELETE')
                                                <button  style="width: 103px;" class="btn btn-danger" onclick="showAlert()" type="submit">
                                                @if ($admin->deleted_at != null)
                                                    <i class="fa fa-undo"></i>
                                                    @else
                                                    <i class="fa fa-trash-o"></i>
                                                    @endif      
                                                </button>
                                               
                                        </form>
                                        
                                    </td>   
                                @endif
                                
                            </tr>
                            @endif 
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