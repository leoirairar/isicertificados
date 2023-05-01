@extends('layouts.app')
 @section('content')
<div class="container">
@if (Auth::user()->role == 'S' || Auth::user()->role == 'M')
    <div class="row">
        <div class="col-md-3 offset-md-9 col-sm-3">
            <a class="btn btn-success btn-block" href="{{ url('/company') }}">
            Crear empresa
            </a>
            <br>
        </div>  
    </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="font-weight: bold">Empresas</div>
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <div class="card-body">
                    @if (Session::has('message'))
                        <div class="alert alert-success fade show">{{ Session::get('message') }}</div>
                    @endif
                    <table class="table table-striped table-hover" id="companiesTable">
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="font-weight: bold">Empresas</div>
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
                            <th>Nit</th>
                            <th>Telefono</th>
                            <th>Estado</th>
                            <th colspan="2">&nbsp;</th>
                        </thead>
                        <tbody>
                            @foreach ($companies as $company)
                            <tr>
                                <td>{{$company->company_name}}</td>
                                <td>{{$company->nit}}</td>
                                <td>{{$company->phone_number}}</td>
                                <td>{{($company->deleted_at == null)?'Activo':'Inactivo'}}</td>
                                <td width="10px">
                                    <a href="{{url('getCompanyInformation/'.$company->id)}}" class="btn btn-success">detalle</a>
                                </td>
                                <td width="10px">
                                    <a href="{{url('editCompany/'.$company->id)}}" class="btn btn-success">editar</a>
                                </td>
                                @if (Auth::user()->role == 'S' || Auth::user()->role == 'M')
                                    <td width="10px">
                                        <form action="{{url('deleteCompany/'.$company->id)}}" method="post">
                                                
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger" style="width: 103px;" onclick="showAlert()" type="submit">
                                                @if ($company->deleted_at != null)
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
    </div> --}}
</div>
@endsection @section('scripts')
<script src="{{ asset('js/datatables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/app/general.js') }}"></script>
<script src="{{ asset('js/app/company.js') }}"></script>
@endsection