@extends('layouts.app')
 @section('content')
<div class="container">
@if (Auth::user()->role == 'S' || Auth::user()->role == 'M')
<div class="row">
        <div class="col-md-3 offset-md-9 col-sm-3">
            <a class="btn btn-success btn-block" href="{{ url('/documentType') }}">
            Crear Tipo de Documento
            </a>
            <br>
        </div>  
    </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="font-weight: bold">Tipo de documentos </div>
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
                            <th>Estado</th>
                            <th colspan="2">&nbsp;</th>
                        </thead>
                        <tbody>
                            @foreach ($documentsType as $documentType)
                            
                                <tr>
                                    <td>{{$documentType->id}}</td>
                                    <td>{{$documentType->name}}</td>
                                    <td>{{ ($documentType->deleted_at == null)?'Activo':'Inactivo' }}</td>
                                    <td width="10px">
                                        <a href="{{url('editDocumentType/'.$documentType->id)}}" class="btn btn-success">editar</a>
                                    </td>
                                    @if (Auth::user()->role == 'S' || Auth::user()->role == 'M')
                                        <td width="10px">
                                            <form action="{{url('deleteDocumentType/'.$documentType->id)}}" method="post">
                                                    
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger" style="width: 103px;" onclick="showAlert()" type="submit">
                                                    @if ($documentType->deleted_at != null)
                                                    <a class="">Activar</a>
                                                    @else
                                                    <a class="">Desactivar</a>
                                                    @endif                                                
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