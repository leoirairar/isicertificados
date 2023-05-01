@extends('layouts.app')
@section('content')
<div class="">
   <div class="">
      <div class="col-md-12">
         <div class="card">
            <div class="card-header" style="font-weight: bold">Formulario de asistencia.</div>
            @if (session('error'))
               <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="card-body">
                  <div class="">
                     <div class="row">
                        <div class="col-sm-12">
                           <form amethod="POST" class="form-inline" action="{{ route('getAttendanceProgrammedCoursesByDates') }}">
                              @csrf
                            <div class="form-group col-md-2 mx-sm-3 mt-3">
                                 <input id="dateOne" type="date" class="col-md-12 form-control @error('dateOne') is-invalid @enderror" name="dateOne" value="{{ old('dateOne') }}" required  autocomplete="dateOne" autofocus>
                            </div>
                            <div class="form-group col-md-2 mx-sm-3 mt-3">
                                 <input id="dateTwo" type="date" class="col-md-12 form-control @error('dateTwo') is-invalid @enderror" name="dateTwo" value="{{ old('dateTwo') }}" required  autocomplete="dateTwo" autofocus>  
                            </div>
                            <div class="form-group mx-sm-3 mt-3"> 
                              <button type="submmit" class="btn bbtn btn-primary">{{ __('Filtrar') }}</button>     
                            </div>
                           </form>
                        </div>
                     </div>
                     <div class="row">
                         <div class="col-sm-8 mt-3">
                           <select class="form-control col-md-12" name="programmedCourses" id="programmedCourses">
                              <option value="">Por favor seleccione una opción</option>
                              @foreach ($coursesProgrammed as $courseProgrammed)
                              <option value="{{ $courseProgrammed->id }}">{{ $courseProgrammed->course->name.' - Inicio '.\Carbon\Carbon::parse($courseProgrammed->begin_date)->format('d/m/Y').' '.(($courseProgrammed->group != 0)?'GRUPO '.$courseProgrammed->group:'').' '.$courseProgrammed->id}}</option>
                              @endforeach
                           </select>  
                         </div>
                     </div>
                     <div class=" row mt-3">
                     <div id="btnSave" class="col-md-12 ">
                         {{-- <a href="{{url('exportCourseProgamingAttendance/'.$courseEnrollment->id)}}" class="btn btn-success">Generar lista</a> --}}
                         <button type="button" id="btnAttendanceCourse" class="btn btn-success mt-3" style="margin-top: 14px;">Generar lista</button>
                     </div>
                  </div>
               @if (Session::has('message'))
                        <div class="alert mt-3 alert-success fade show">{{ Session::get('message') }}</div>
               @endif
               @if (Session::has('error2'))
                        <div class="alert mt-3 alert-danger fade show">{{ Session::get('error2') }}</div>
               @endif
               @if (Session::has('warning'))
                        <div class="alert mt-3 alert-danger fade show">{{ Session::get('warning') }}</div>
               @endif
               <div class="container mt-5 border" id="cotentAttendanceList">
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('scripts')
@routes
<script src="{{ asset('js/app/attendance.js') }}"></script>
@endsection

