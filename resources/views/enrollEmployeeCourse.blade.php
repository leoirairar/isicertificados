@extends('layouts.app') 
@section('content')
@php
    setlocale(LC_ALL,'es_ES.UTF-8');
@endphp
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-12">
         <div class="card shadow ">
            <div class="card-header" style="font-weight: bold">Preinscripcion de empleado</div>
            @if (session('error'))
               <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="card-body">
               <form id="enrollmentForm" method="POST" action="{{ route('insertCourseAssignment') }}" enctype="multipart/form-data" onsubmit="return validateMyForm();">
               @csrf 
               <div class="py-5 text-center">
                  {{-- <h1>{{$company->company_name}}</h1> --}}
               </div>
               <div class="row">
                  <div class="col-md-7 order-md-1 pl-5">
                     <h4 data-type="header" class="d-flex justify-content-between align-items-center mb-3">
                        <span>Datos de la empresa</span> 
                     </h4>
                     <div data-type="default" class="row">
                        <div data-type="default" class="col-md-8 mb-3">
                           <label for="firstName">Empresa</label>
                           <select class="form-control company" id="company" name="company"  required autocomplete="current-company">
                               <option value="">Selecciona una opción</option>
                               @foreach ($companies as $company)
                               <option value="{{ $company->id }}">{{ $company->company_name}}</option> 
                               @endforeach
                           </select>
                        </div>
                    </div>
                    <div data-type="default" class="row">
                        <div data-type="default" class="col-md-8 col-sd-6 mb-3">
                           <label for="Employee">Empleado</label>
                           <select class="form-control  @error('employee') is-invalid @enderror employee" id="employee" name="employee"  required autocomplete="current-employee">
                            <option value="">Selecciona una opción</option>
                             {{--@foreach ($company->employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->user->name}} {{$employee->user->last_name}}</option> 
                            @endforeach --}}
                        </select>
                        </div>
                     </div>
                  </div>
                  {{-- <div class="col-md-4 order-md-2 mb-4">
                     <h4 data-type="header" class="d-flex justify-content-between align-items-center mb-3">
                        <span >Cursos Programados</span>
                        <span class="badge badge-secondary badge-pill">{{''}}</span>
                     </h4>
                     <div class="">
                           <ul class="list-group mt-2">
                                <select class="form-control @error('course') is-invalid @enderror course "  id="course"  name="course" required autocomplete="current-course">
                                        <option value="">Selecciona una opción</option>
                                        @foreach ($coursesProgramming as $courseProgramming)
                                        <li class="list-group-item"><option value="{{ $courseProgramming->id }}" courseid={{$courseProgramming->course->id}}>
                                           {{ $courseProgramming->course->name.' ('.\Carbon\Carbon::parse($courseProgramming->begin_date)->formatLocalized('%A').'-'.\Carbon\Carbon::parse($courseProgramming->end_date)->formatLocalized('%A').') '. \Carbon\Carbon::parse($courseProgramming->begin_date)->formatLocalized('%d %B %Y')}}
                                          </option></li>
                                        @endforeach
                                </select>
                            </ul>
                     </div>
                  </div> --}}
               </div>
               <div class="row">
                  <h4 data-type="header" class="d-flex justify-content-between align-items-center mb-3 pl-5">
                        <span >Cursos Programados</span>
                        <span class="badge badge-secondary badge-pill">{{''}}</span>
                  </h4>
                    <div class="col-md-12 pl-5 mb-3">
                        <label for="course" class="">{{ __('Curso Seleccionado') }}</label>
                    
                        <div class="row">
                            <div class="col-md-6" id="selected-course" style="font-size: 20px;"></div>
                            <input type="hidden" name="courseProgrammedId" value="" id="courseProgrammedId">
                            <input type="hidden" name="" value="" id="courseId">
                        <div class=" col-md-6">
                            <button  type="button" id="cancel" class="btn btn-danger">
                                Cancelar
                            </button>
                        </div>
                           
                            {{-- <input type="hidden" name="" value="{{$documentsByCourse}}" id="documentsBycourse"> --}}
                        </div>
                    </div>
                  <div class="container">
                        <div id='calendar' class="col-md-12 mx-auto"></div>
                    </div>
               </div>
               <hr>
               <div class="row">
                   <div class="col-md-7 pt-4 pl-5 pb-5">
                        <h4 data-type="header" class="d-flex justify-content-between align-items-center mb-3">
                                <span>Adjuntar documentos</span> 
                        </h4>
                        <div class="attachment" id="attachment">
                        </div>         
                   </div>
                   <div class="col-md-4 pt-4 pl-5 pb-5">  
                        <h4 data-type="header" class="d-flex justify-content-between align-items-center mb-3">
                                <span>Documentos cargados</span> 
                                
                        </h4>    
                        <div class="overflow-auto">
                              <ul class="list-group mt-2" id="attachedDocuments">
                                    {{-- <li class="list-group-item">hola</li>
                                    <li class="list-group-item">hola2</li> --}}
                                 </ul>
                           </div>  
                   </div>
               </div>
               
               <div class="form-group row mb-0">
                     <div class="col-md-3 offset-md-8">
                         <button type="submit" class="btn btn-primary">
                             {{ __('Guardar documento') }}
                         </button>
                     </div>
                 </div>
             </form>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection @section('scripts')
@routes
<script src="{{ asset('js/select2.min.js') }}"></script>
<script src="{{ asset('js/fullcalendar/core/main.js') }}"></script>
<script src="{{ asset('js/fullcalendar/daygrid/main.js') }}"></script>
<script src="{{ asset('js/fullcalendar/core/locales/es.js') }}"></script>
<script src="{{ asset('js/app/preEnroll.js') }}"></script>
@endsection

