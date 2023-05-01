@extends('layouts.app')

@section('content')
@php
    setlocale(LC_ALL,'es_ES.UTF-8');
@endphp
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="font-weight: bold">Registrar Empleado</div>
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <div class="card-body" id="cardbody" data-course_validation="{{session('course_validation')}}">
                    <form method="POST" id="employeeForm" action="{{ route('insertEmployee') }}" onsubmit="return validateMyForm();" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="birthdate" class="col-md-6 text-danger text-md-right">{{ __('Los campos con * son obligatorio') }}</label>
                        </div>

                        @include('generalUser')
                    <div class="form-group row">
                        <label for="hemo_classification" class="col-md-4 col-form-label text-md-right">{{ __('RH') }}</label>

                        <div class="col-md-6">
                            <select class="form-control @error('hemo_classification') is-invalid @enderror hemo_classification "  id="hemo_classification"  name="hemo_classification"  autocomplete="current-hemo_classification" required>
                                    <option value="">Selecciona una opción</option>
                                    <option value="A+" >{{'A+'}}</option>
                                    <option value="A-" >{{'A-'}}</option>
                                    <option value="O+" >{{'O+'}}</option>
                                    <option value="O-" >{{'O-'}}</option>
                                    <option value="B+" >{{'B+'}}</option>
                                    <option value="B-" >{{'B-'}}</option>
                                    <option value="AB+" >{{'AB+'}}</option>
                                    <option value="AB-" >{{'AB-'}}</option>
                            </select>
                        </div>
                    </div>
                        <div class="form-group row">
                            <label for="birthdate" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de nacimiento') }}</label>


                        <div class="col-md-6">
                            <input id="birthdate" type="date" class="form-control @error('birthdate') is-invalid @enderror" name="birthdate" value="{{ old('birthdate') }}"  autocomplete="birthdate" autofocus required>

                            @error('birthdate')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="academy_degree" class="col-md-4 col-form-label text-md-right">{{ __('Nivel educativo') }}</label>

                        <div class="col-md-6">
                            <select class="form-control @error('academy_degree') is-invalid @enderror academy_degree" id="academy_degree" name="academy_degree"   autocomplete="current-academy_degree" required>
                                <option value="">Selecciona una opción</option>
                                @foreach ($academicDegrees as $academy_degree)
                                <option value="{{ $academy_degree->id }}" {{($academy_degree->id == 0)? 'selected':''}} >{{ $academy_degree->name}}</option>
                                @endforeach
                            </select>
                            @error('academy_degree')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span> @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="company" class="col-md-4 col-form-label text-md-right">{{ __('Empresa ') }} <label for="" class="" style="color: red;">*</label></label>

                        <div class="col-md-6">
                            <select required class="form-control @error('company') is-invalid @enderror company" id="company" name="company"   autocomplete="current-company" required>
                                <option value="">Selecciona una opción</option>
                                @foreach ($companies as $company)
                                <option value="{{ $company->id."-".$company->company_name }}">{{ $company->company_name}}</option>
                                @endforeach
                            </select>

                            @error('company')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span> @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="position" class="col-md-4 col-form-label text-md-right">{{ __('Cargo ') }} <label for="" class="" style="color: red;">*</label></label>

                        <div class="col-md-6">
                            <input id="position" type="text" style="text-transform:uppercase;" class="form-control @error('position') is-invalid @enderror" name="position" value="{{ old('position') }}"  autocomplete="position" autofocus required>
                            @error('position')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span> @enderror
                        </div>
                    </div>
                                                <div class="form-group row">
                                <label for="sector_economico"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Sector económico') }}</label>
                                <div class="col-md-6">
                                    <select class="form-control @error('sector_economico') is-invalid @enderror sector_economico"  id="sector_economico" name="sector_economico"  required autocomplete="current-sector_economico">
                                        <option disabled value="">Selecciona una opción</option>
                                        <option value="Sector agropecuario<">Sector agropecuario</option>
                                        <option value="Sector comercio y servicios">Sector comercio y servicios</option>
                                        <option value="Sector industrial">Sector industrial</option>
                                        <option value="Sector de transporte">Sector de transporte</option>
                                        <option value="Sector de comercio">Sector de comercio</option>
                                        <option value="Sector financiero">Sector financiero</option>
                                        <option value="Sector de la construcción">Sector de la construcción</option>
                                        <option value="Sector minero y energético">Sector minero y energético</option>
                                        <option value="Sector de telecomunicaciones">Sector de telecomunicaciones</option>
                                        <option value="Sector de educación">Sector de educación</option>
                                    </select>
                                    @error('sector_economico')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                    <div class="form-group row">
                        <label for="emergency_contact_name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre contacto de emergencia') }}</label>

                        <div class="col-md-6">
                            <input id="emergency_contact_name" type="text" style="text-transform:uppercase;" class="form-control @error('emergency_contact_name') is-invalid @enderror" name="emergency_contact_name" value="{{ old('emergency_contact_name') }}"  autocomplete="emergency_contact_name" autofocus required>
                             @error('emergency_contact_name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                            </span>
                             @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="emergency_phone_number" class="col-md-4 col-form-label text-md-right">{{ __('Número telefónico contacto de emergencia') }}</label>

                        <div class="col-md-6">
                            <input id="emergency_phone_number" type="text" class="form-control @error('emergency_phone_number') is-invalid @enderror" name="emergency_phone_number" value="{{ old('emergency_phone_number')  }}"  autocomplete="emergency_phone_number" autofocus required>
                             @error('emergency_phone_number')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span> @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="literacy_level" class="col-md-4 col-form-label text-md-right">{{ __('Nivel de lectoescritura') }}</label>

                        <div class="col-md-6">
                            <select class="form-control @error('literacy_level') is-invalid @enderror literacy_level "  id="literacy_level"  name="literacy_level"  autocomplete="current-literacy_level" required>
                                    <option value="">Selecciona una opción</option>
                                    <option value="Lee y escribe" >{{'Lee y escribe'}}</option>
                                    <option value="Lee pero no escribe" >{{'Lee pero no escribe'}}</option>
                                    <option value="Escribe pero no lee" >{{'Escribe pero no lee'}}</option>
                                    <option value="No lee ni escribe" >{{'No lee ni escribe'}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="allergies" class="col-md-4 col-form-label text-md-right">{{ __('Alergias') }}</label>

                        <div class="col-md-6">
                            <input id="allergies" type="text" class="form-control @error('allergies') is-invalid @enderror" name="allergies" value="{{ 'NA' }}"  autocomplete="allergies" autofocus required>
                             @error('allergies')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span> @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="recent_medication_use" class="col-md-4 col-form-label text-md-right">{{ __('Consumo reciente de medicamentos') }}</label>

                        <div class="col-md-6">
                            <input id="recent_medication_use" type="text" class="form-control @error('recent_medication_use') is-invalid @enderror" name="recent_medication_use" value="{{ 'NA' }}"  autocomplete="recent_medication_use" autofocus required>
                             @error('recent_medication_use')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span> @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="recent_Injuries" class="col-md-4 col-form-label text-md-right">{{ __('Lesiones reciente') }}</label>

                        <div class="col-md-6">
                            <input id="recent_Injuries" type="text" class="form-control @error('recent_Injuries') is-invalid @enderror" name="recent_Injuries" value="{{ 'NA'  }}"  autocomplete="recent_Injuries" autofocus required>
                             @error('recent_Injuries')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span> @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="current_diseases" class="col-md-4 col-form-label text-md-right">{{ __('Enfermedades actuales') }}</label>

                        <div class="col-md-6">
                            <input id="current_diseases" type="text" class="form-control @error('current_diseases') is-invalid @enderror" name="current_diseases" value="{{ 'NA'  }}"  autocomplete="current_diseases" autofocus required>
                             @error('current_diseases')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span> @enderror
                        </div>
                    </div>
                    {{-- <div class="form-group row">
                        <label for="course" class="col-md-4 col-form-label text-md-right">{{ __('Cursos programados') }}</label>

                        <div class="col-md-6">
                            <select class="form-control @error('course') is-invalid @enderror course "  id="course"  name="course"  autocomplete="current-course">
                                    <option value="">Selecciona una opción</option>
                                    @foreach ($coursesProgramming as $courseProgramming)
                                    <li class="list-group-item"><option value="{{ $courseProgramming->id."-".$courseProgramming->course->name."-".$courseProgramming->course->id }}" courseid={{$courseProgramming->course->id}}>
                                        {{$courseProgramming->course->name.' ('.\Carbon\Carbon::parse($courseProgramming->begin_date)->formatLocalized('%A').'-'.\Carbon\Carbon::parse($courseProgramming->end_date)->formatLocalized('%A').') '. \Carbon\Carbon::parse($courseProgramming->begin_date)->formatLocalized('%d %B %Y')}}
                                       </option></li>
                                    @endforeach
                            </select>
                        </div>
                    </div> --}}
                    <div class="form-group row">
                        <label for="course" class="col-md-4 col-form-label text-md-right">{{ __('Curso Seleccionado') }}</label>

                        <div class="col-md-4">
                            <div id="selected-course" style="font-size: 20px;"></div>
                            <input type="hidden" name="course" value="" id="courseProgrammedId">
                            <input type="hidden" name="" value="" id="courseId">
                            <input type="hidden" name="" value="{{$documentsByCourse}}" id="documentsBycourse">
                        </div>
                        <div class="col-md-4">
                            <button type="button" id="cancel" class="btn btn-danger">
                                Cancelar
                            </button>
                        </div>
                    </div>
                    <div class="container">
                        <div id='calendar' class="col-md-9 mx-auto"></div>
                    </div>
                        {{-- @include('credentials',['update'=> 'N','needPass'=>'N']) --}}


                         {{-- Inicia lo que tengo que pasar  --}}

                 <hr>
                 <div class="row">
                     <div class="col-md-7 pt-4 pl-5 pb-5">
                          <h4 data-type="header" class="d-flex justify-content-between align-items-center mb-3">
                                  <span>Adjuntar documentos</span>
                          </h4>
                          {{-- <div class="attachment" id="attachment">
                          </div> --}}

                            @for ($i = 0; $i < $files->count(); $i++)
                            <div class="row">
                                <div data-type='default' class='col-md-8 mt-3'>
                                    <label style="font-weight: 700 ">{{$files[$i]->name}}</label>
                                    <div><label id="{{"labelFileId".$files[$i]->id}}">  </label></div>
                                    <input class='form-control form-control-file target' type='file' id='{{$files[$i]->name."-".$files[$i]->id }}' value='' onchange='showname(this);' data-id='{{$files[$i]->id}}' name='docFiles[]' data-name ="{{$files[$i]->name}}"  autofocus='autofocus'>
                                    <input id='fileid' name='fileid[]' type='hidden' value='{{$files[$i]->id}}'>
                                    {{-- <input id='documentTypes' type='hidden' value="{{$files}}"> --}}
                                </div>
                            </div>
                            @endfor

                     </div>
                     <div class="col-md-4 pt-4 pl-5 pb-5">
                          <h4 data-type="header" class="d-flex justify-content-between align-items-center mb-5">
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
                 {{-- hasta aca es donde tengo que pasar. --}}
                 <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" id="button" class="btn btn-primary">
                                {{ __('Guardar Empleado') }}
                            </button>
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
@routes
<script src="{{ asset('js/fullcalendar/core/main.js') }}"></script>
<script src="{{ asset('js/fullcalendar/daygrid/main.js') }}"></script>
<script src="{{ asset('js/fullcalendar/core/locales/es.js') }}"></script>
<script src="{{ asset('js/app/employee.js') }}"></script>
@endsection
