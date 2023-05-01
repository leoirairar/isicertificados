@extends('layouts.app')
 @section('content')
<div class="container">
<div class="row">
        <div class="col-md-3 offset-md-9 col-sm-3">
            <a class="btn btn-success btn-block" href="{{ url('/administratorisi') }}">
            Crear Administrador ISI
            </a>
            <br>
        </div>  
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="font-weight: bold">Administradores ISI </div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if (Session::has('message'))
                        <div class="alert alert-success fade show">{{ Session::get('message') }}</div>
                    @endif
                    <table class="table table-striped table-hover">
                        <thead>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Correo</th>
                            <th>Teléfono</th>
                            <th>Empresa</th>
                            <th>cargo</th>
                            <th>Estado</th>
                            <th colspan="2">&nbsp;</th>
                        </thead>
                        <tbody>
                            @foreach ($administrator as $admin)
                            @if(isset($admin->user->role))
                            @if($admin->user->role == 'M')
                                <tr>
                                    <td>{{$admin->user->name}}</td>
                                    <td>{{$admin->user->last_name}}</td>
                                    <td>{{$admin->user->email}}</td>
                                    <td>{{$admin->user->phone_number}}</td>
                                    <td>{{$admin->company->company_name}}</td>
                                    <td>{{($admin->deleted_at == null)?'Activo':'Inactivo'}}</td>
                                    <td width="10px">
                                        <a href="{{url('editAdministrator/'.$admin->id)}}" class="btn btn-success">editar</a>
                                    </td>
                                    @if (Auth::user()->role == 'S' || Auth::user()->role == 'M')
                                        <td width="10px">
                                            <form action="{{url('deleteAdministrator/'.$admin->id)}}" method="post">
                                                    
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger" style="width: 103px;" onclick="showAlert()" type="submit">{{($admin->deleted_at != null)?'Habilitar':'Deshabilitar'}}</button>
                                                
                                            </form>
                                            
                                        </td>   
                                    @endif
                                    
                                </tr>
                             @endif 
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