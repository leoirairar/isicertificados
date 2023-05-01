

@extends('layouts.app')
@section('content')
<div class="">
   <div class="">
      <div class="col-md-12">
         <div class="card">
            <div class="card-header" style="font-weight: bold">Generar certificados</div>
            @if (session('error'))
               <div class="alert alert-danger">{{ session('error') }}</div>
               
            @endif
            <div class="card-body">
               <div class="alert alert-info">
                     <span>Por favor seleccione la empresa a la que desea generar los certificados, aqui puede seleccionar solo por empresa o por curso - empresa </span>
                  </div>
               <div class=" d-flex flex-row ">
                  <div class="col-md-8 col-sm-8">
                        <div class=" d-flex flex-row ">
                           <div class="col-md-8 ml-2">
                              <span>Curso</span>
                              <select class="form-control col-md-12" name="programmedCourses" id="programmedCourses">
                                 <option value="">Por favor seleccione una opcion</option>
                                 @foreach ($coursesProgrammed as $courseProgrammed)
                                 <option value="{{ $courseProgrammed->id }}">{{$courseProgrammed->course->id.' - '.$courseProgrammed->course->name.' - '.\Carbon\Carbon::parse($courseProgrammed->begin_date)->format('d/m/Y').(($courseProgrammed->group != 0)?' - Grupo  '.$courseProgrammed->group:'')}}</option>
                                 @endforeach
                              </select>
                           </div>
                        </div>
                        <div class=" d-flex flex-row ">
                           <div class="col-md-8 ml-2 mt-4">
                              <span>Empresa</span>
                              <select class="form-control col-md-12" name="programmedCourses" id="companies">
                                 <option value="">Por favor seleccione una opcion</option>
                                 @foreach ($companies as $companie)
                                 <option value="{{ $companie->id }}">{{ $companie->company_name}}</option>
                                 @endforeach
                              </select>
                           </div>
                        </div>
                        <div class="col-md-5 ml-2">
                           <button type="button" id="btnFilter" class="btn btn-info" style="margin-top: 14px;">Filtrar</button>
                        </div>
                  </div>
                  
               </div>
               <button type="button" id="btnCertificatesCompany" class="btn btn-success mt-3" style="margin-top: 14px;">Enviar certificados a empresa</button>
               <div id="content">
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('scripts')
@routes
<script src="{{ asset('js/app/certificates.js') }}"></script>
@endsection

