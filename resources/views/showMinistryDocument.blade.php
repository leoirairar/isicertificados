@extends('layouts.app')
@section('content')
<div class="">
   <div class="">
      <div class="col-md-12">
         <div class="card">
            <div class="card-header" style="font-weight: bold">Consultar datos al ministerio</div>
            @if (session('error'))
               <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="card-body">
                  <div class="">
                     <div class="row">
                        <div class="col-sm-12">
                           <form amethod="POST" class="form-inline" action="{{ route('getFinishedCoursesBydates') }}">
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
                              <option value="{{ $courseProgrammed->id }}">{{ $courseProgrammed->course->name.' - Inicio '.\Carbon\Carbon::parse($courseProgrammed->begin_date)->format('d/m/Y')}}</option>
                              @endforeach
                           </select>  
                         </div>
                     </div>
                  </div>
               <div id="cotent">
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('js/app/ministryFile.js') }}"></script>
@endsection

