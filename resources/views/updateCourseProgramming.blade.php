@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="font-weight: bold">Editar programación Curso</div>
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <div class="card-body">

                        <form method="POST" action="{{ route('updateCourseProgramming',$courseProgrammed->id) }}">
                                @csrf 
                                @method('PUT')
                                <div class="form-group row">
                                        <label for="course" class="col-md-4 col-form-label text-md-right">{{ __('Curso') }}</label>
            
                                        <div class="col-md-6">
                                            <select class="form-control @error('course') is-invalid @enderror course" id="course" name="course"  required autocomplete="current-course">
                                                <option value="">Selecciona una opción</option>
                                                @foreach ($courses as $course)
                                                <option value="{{ $course->id }}" {{($course->id == $courseProgrammed->course_id) ? 'selected':''}}>{{ $course->name}}</option> 
                                                @endforeach
                                            </select>
            
                                            @error('course')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span> @enderror
                                        </div>
                                    </div>

                                <div class="form-group row">
                                        <label for="duration" class="col-md-4 col-form-label text-md-right">{{ __('Duración') }}</label>
            
                                        <div class="col-md-6">
                                            <input id="duration" type="text" class="form-control @error('duration') is-invalid @enderror" name="duration" value="{{$courseProgrammed->duration }}" required autocomplete="duration" autofocus>
                                            @error('duration')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span> @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                            <label for="begin_hour" class="col-md-4 col-form-label text-md-right">{{ __('Hora de inicio') }}</label>
                                            

                                            <div class="input-group date col-md-6" id="datetimepicker3" data-target-input="nearest">
                                                    <input type="text"  id="begin_hour" class="form-control datetimepicker-input @error('begin_hour') is-invalid @enderror" data-target="#datetimepicker3" name="begin_hour" value="{{ $courseProgrammed->begin_hour }}" required autocomplete="begin_hour" autofocus/>
                                                    <div class="input-group-append" data-target="#datetimepicker3" data-toggle="datetimepicker">
                                                            <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                        </div>
                                            </div>
                                            @error('begin_hour')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span> @enderror                                   
                                    </div>

                                    {{-- <div class="form-group row">
                                            <label for="end_hour" class="col-md-4 col-form-label text-md-right">{{ __('Hora de inicio') }}</label>
                                            
                                            <div class="input-group date col-md-6" id="datetimepicker5" data-target-input="nearest">
                                                    <input type="text" id="end_hour" class="form-control datetimepicker-input @error('end_hour') is-invalid @enderror" data-target="#datetimepicker5" name="end_hour" value="{{ $courseProgrammed->end_hour }}" required autocomplete="end_hour" autofocus/>
                                                    <div class="input-group-append" data-target="#datetimepicker5" data-toggle="datetimepicker">
                                                            <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                        </div>
                                                </div>
                                            @error('end_hour')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span> @enderror                                   
                                    </div> --}}

                                    
                                    <div class="form-group row">
                                            <label for="place" class="col-md-4 col-form-label text-md-right">{{ __('Lugar de asistencia') }}</label>
                
                                            <div class="col-md-6">
                                                <input id="place" type="text" class="form-control @error('place') is-invalid @enderror" name="place" value="{{ $courseProgrammed->place }}" required autocomplete="place" autofocus>
                                                @error('place')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span> @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                                <label for="scheduled_days" class="col-md-4 col-form-label text-md-right">{{ __('Fechas del curso. ') }}</label>
                                                @php
                                                
                                                @endphp
                                                <div class="input-group date col-md-6" id="datetimepicker6">
                                                        <input  id="scheduled_days" type="text"  class="form-control @error('scheduled_days') is-invalid @enderror"  data-target="#datetimepicker6" name="scheduled_days" value="{{ $courseProgrammed->courseDays->implode('date',',') }}" required autocomplete="scheduled_days" autofocus >
                                                        <div class="input-group-append" data-target="#datetimepicker6" data-toggle="datepicker">
                                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                            </div>
                                                    </div>
                                                @error('scheduled_days')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span> @enderror                                   
                                            </div>
                                
                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Guardar programacion de curso') }}
                                        </button>
                                        <a class="btn btn-danger" href="{{ url('/getCourseProgramming') }}">Regresar</a>
                                    </div>
                                </div>
                            </form>                  
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('js/app/courseProgramming.js') }}"></script>

<script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('js/tempusdominus-bootstrap-4.min.js') }}"></script>

@endsection
