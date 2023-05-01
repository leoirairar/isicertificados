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
                    <div class=" d-flex flex-row-reverse ">
                            <div class="col-md-4">
                                    <button type="button" name="filter" id="filter" class="btn bbtn btn-primary">Filtrar</button>
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
                    <div class="row">
                        <div class="col-md-12 mt-5">
                            <table id="employeesEnrolled" class="table table-striped table-hover">
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
<!-- Modal -->
<div class="modal fade" id="docsModal" tabindex="-1" role="dialog" aria-labelledby="lableModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="lableModal">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
         <div class="modal-body">
            <form method="post" action="{{ route('updateFilesState') }}">
            @csrf 
            @method('post')
            <div class="d-flex flex-row justify-content-center" >
                <div class="d-flex flex-column bd-highlight col-md-8" id="flexColumnContainer">
            </div>
            <div >
               <div id="fileAlert" class="alert alert-danger fade show">{{ Session::get('message') }}</div>
            </div>
                   
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Guardar criterios</button>
        </form>      
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

@endsection 

@section('scripts')
@routes
<script src="{{ asset('js/datatables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/app/preEnrollertables.js') }}"></script>
@endsection