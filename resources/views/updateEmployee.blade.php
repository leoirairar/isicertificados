@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="font-weight: bold">Editar Empleado</div>
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <div class="card-body">
                        <form method="POST" id="employeeForm" action="{{ route('updateEmployee', $employee->id) }}"
                            onsubmit="return validateMyForm();" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group row">
                                <label for="birthdate"
                                    class="col-md-6 text-danger text-md-right">{{ __('Los campos con * son obligatorio') }}</label>
                            </div>
                            @include('generalUser', ['user' => $employee->user])
                            <input type="hidden" name="" id="employeeId" value="{{ $employee->id }}">
                            <div class="form-group row">
                                <label for="birthdate"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Fecha de nacimiento') }}</label>


                                <div class="col-md-6">
                                    <input id="birthdate" type="date"
                                        class="form-control @error('birthdate') is-invalid @enderror" name="birthdate"
                                        value="{{ $employee->birthdate }}" autocomplete="birthdate" autofocus>

                                    @error('birthdate')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="academy_degree"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Nivel educativo') }}</label>

                                <div class="col-md-6">
                                    <select
                                        class="form-control @error('academy_degree') is-invalid @enderror academy_degree"
                                        id="academy_degree" name="academy_degree" autocomplete="current-academy_degree">
                                        <option value="">Selecciona una opción</option>
                                        @foreach ($academicDegrees as $academy_degree)
                                            <option value="{{ $academy_degree->id }}"
                                                {{ $academy_degree->id == $employee->academy_degree_id ? 'selected' : '' }}>
                                                {{ $academy_degree->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('academy_degree')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="company"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Empresa ') }}<label for=""
                                        class="">*</label></label>

                                <div class="col-md-6">
                                    <select class="form-control @error('company') is-invalid @enderror company"
                                        id="company" name="company" required autocomplete="current-company">
                                        <option value="">Selecciona una opción</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}"
                                                {{ $company->id == $employee->company_id ? 'selected' : '' }}>
                                                {{ $company->company_name }}</option>
                                        @endforeach
                                    </select>

                                    @error('company')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="position"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Cargo') }}</label>

                                <div class="col-md-6">
                                    <input id="position" type="text"
                                        class="form-control @error('position') is-invalid @enderror" name="position"
                                        value="{{ $employee->position }}" autocomplete="position" autofocus>
                                    @error('position')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="sector_economico"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Sector económico') }}</label>
                                <div class="col-md-6">
                                    <select
                                        class="form-control @error('sector_economico') is-invalid @enderror sector_economico"
                                        id="sector_economico" name="sector_economico" required
                                        autocomplete="current-sector_economico">
                                        <option disabled value="">Selecciona una opción</option>
                                        <option value="Sector agropecuario"
                                            {{ $company->sector_economico == 'Sector agropecuario' ? 'selected' : '' }}>Sector
                                            agropecuario</option>
                                        <option value="Sector comercio y servicios"
                                            {{ $company->sector_economico == 'Sector comercio y servicios' ? 'selected' : '' }}>
                                            Sector comercio y servicios</option>
                                        <option value="Sector industrial"
                                            {{ $company->sector_economico == 'Sector industrial' ? 'selected' : '' }}>Sector
                                            industrial</option>
                                        <option value="Sector de transporte"
                                            {{ $company->sector_economico == 'Sector de transporte' ? 'selected' : '' }}>Sector
                                            de transporte</option>
                                        <option value="Sector de comercio"
                                            {{ $company->sector_economico == 'Sector de comercio' ? 'selected' : '' }}>Sector de
                                            comercio</option>
                                        <option value="Sector financiero"
                                            {{ $company->sector_economico == 'Sector financiero' ? 'selected' : '' }}>Sector
                                            financiero</option>
                                        <option value="Sector de la construcción"
                                            {{ $company->sector_economico == 'Sector de la construcción' ? 'selected' : '' }}>
                                            Sector de la construcción</option>
                                        <option value="Sector minero y energético"
                                            {{ $company->sector_economico == 'Sector minero y energético' ? 'selected' : '' }}>
                                            Sector minero y energético</option>
                                        <option value="Sector de telecomunicaciones"
                                            {{ $company->sector_economico == 'Sector de telecomunicaciones' ? 'selected' : '' }}>
                                            Sector de telecomunicaciones</option>
                                        <option value="Sector de educación"
                                            {{ $company->sector_economico == 'Sector de educación' ? 'selected' : '' }}>Sector
                                            de educación</option>
                                    </select>
                                    @error('sector_economico')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="arl"
                                    class="col-md-4 col-form-label text-md-right">{{ __('ARL') }}</label>

                                <div class="col-md-6">
                                    <input id="arl" type="text"
                                        class="form-control @error('arl') is-invalid @enderror" name="arl"
                                        value="{{ $employee->arl }}" autocomplete="arl" autofocus>
                                    @error('arl')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="emergency_contact_name"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Nombre contrato de emergencia') }}</label>

                                <div class="col-md-6">
                                    <input id="emergency_contact_name" type="text"
                                        class="form-control @error('emergency_contact_name') is-invalid @enderror"
                                        name="emergency_contact_name" value="{{ $employee->emergency_contact_name }}"
                                        autocomplete="emergency_contact_name" autofocus>
                                    @error('emergency_contact_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="emergency_phone_number"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Número telefónico contacto de emergencia') }}</label>

                                <div class="col-md-6">
                                    <input id="emergency_phone_number" type="text"
                                        class="form-control @error('emergency_phone_number') is-invalid @enderror"
                                        name="emergency_phone_number" value="{{ $employee->emergency_phone_number }}"
                                        autocomplete="emergency_phone_number" autofocus>
                                    @error('emergency_phone_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="literacy_level"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Nivel de lectoescritura') }}</label>

                                <div class="col-md-6">
                                    <select
                                        class="form-control @error('literacy_level') is-invalid @enderror literacy_level "
                                        id="literacy_level" name="literacy_level" autocomplete="current-literacy_level">
                                        <option value="">Selecciona una opción</option>
                                        <option value="Lee y escribe"
                                            {{ isset($employee->user->literacy_level) ? ($employee->user->literacy_level == 'Lee y escribe' ? 'selected' : '') : '' }}>
                                            {{ 'Lee y escribe' }}</option>
                                        <option value="Lee pero no escribe"
                                            {{ isset($employee->user->literacy_level) ? ($employee->user->literacy_level == 'Lee pero no escribe' ? 'selected' : '') : '' }}>
                                            {{ 'Lee pero no escribe' }}</option>
                                        <option value="Escribe pero no lee"
                                            {{ isset($employee->user->literacy_level) ? ($employee->user->literacy_level == 'Escribe pero no lee' ? 'selected' : '') : '' }}>
                                            {{ 'Escribe pero no lee' }}</option>
                                        <option value="No lee ni escribe"
                                            {{ isset($employee->user->literacy_level) ? ($employee->user->literacy_level == 'No lee ni escribe' ? 'selected' : '') : '' }}>
                                            {{ 'No lee ni escribe' }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="hemo_classification"
                                    class="col-md-4 col-form-label text-md-right">{{ __('RH') }}</label>

                                <div class="col-md-6">
                                    <select
                                        class="form-control @error('hemo_classification') is-invalid @enderror hemo_classification "
                                        id="hemo_classification" name="hemo_classification"
                                        autocomplete="current-hemo_classification">
                                        <option value="">Selecciona una opción</option>
                                        <option value="A+"
                                            {{ isset($employee->user->hemo_classification) ? ($employee->user->hemo_classification == 'A+' ? 'selected' : '') : '' }}>
                                            {{ 'A+' }}</option>
                                        <option value="A-"
                                            {{ isset($employee->user->hemo_classification) ? ($employee->user->hemo_classification == 'A-' ? 'selected' : '') : '' }}>
                                            {{ 'A-' }}</option>
                                        <option value="O+"
                                            {{ isset($employee->user->hemo_classification) ? ($employee->user->hemo_classification == 'O+' ? 'selected' : '') : '' }}>
                                            {{ 'O+' }}</option>
                                        <option value="O-"
                                            {{ isset($employee->user->hemo_classification) ? ($employee->user->hemo_classification == 'O-' ? 'selected' : '') : '' }}>
                                            {{ 'O-' }}</option>
                                        <option value="B+"
                                            {{ isset($employee->user->hemo_classification) ? ($employee->user->hemo_classification == 'B+' ? 'selected' : '') : '' }}>
                                            {{ 'B+' }}</option>
                                        <option value="B-"
                                            {{ isset($employee->user->hemo_classification) ? ($employee->user->hemo_classification == 'B-' ? 'selected' : '') : '' }}>
                                            {{ 'B-' }}</option>
                                        <option value="AB+"
                                            {{ isset($employee->user->hemo_classification) ? ($employee->user->hemo_classification == 'AB+' ? 'selected' : '') : '' }}>
                                            {{ 'AB+' }}</option>
                                        <option value="AB-"
                                            {{ isset($employee->user->hemo_classification) ? ($employee->user->hemo_classification == 'AB-' ? 'selected' : '') : '' }}>
                                            {{ 'AB-' }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="allergies"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Alergias') }}</label>

                                <div class="col-md-6">
                                    <input id="allergies" type="text"
                                        class="form-control @error('allergies') is-invalid @enderror" name="allergies"
                                        value="{{ $employee->user->allergies }}" autocomplete="allergies" autofocus>
                                    @error('allergies')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="recent_medication_use"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Consumo reciente de medicamentos') }}</label>

                                <div class="col-md-6">
                                    <input id="recent_medication_use" type="text"
                                        class="form-control @error('recent_medication_use') is-invalid @enderror"
                                        name="recent_medication_use" value="{{ $employee->user->recent_medication_use }}"
                                        autocomplete="recent_medication_use" autofocus>
                                    @error('recent_medication_use')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="recent_Injuries"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Lesiones reciente') }}</label>

                                <div class="col-md-6">
                                    <input id="recent_Injuries" type="text"
                                        class="form-control @error('recent_Injuries') is-invalid @enderror"
                                        name="recent_Injuries" value="{{ $employee->user->recent_Injuries }}"
                                        autocomplete="recent_Injuries" autofocus>
                                    @error('recent_Injuries')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="current_diseases"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Enfermedades actuales') }}</label>

                                <div class="col-md-6">
                                    <input id="current_diseases" type="text"
                                        class="form-control @error('current_diseases') is-invalid @enderror"
                                        name="current_diseases" value="{{ $employee->user->current_diseases }}"
                                        autocomplete="current_diseases" autofocus>
                                    @error('current_diseases')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="course"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Curso Seleccionado') }}</label>

                                <div class="col-md-4">
                                    <div id="selected-course" style="font-size: 20px;"></div>
                                    <input type="hidden" name="course" value="" id="courseProgrammedId">
                                    <input type="hidden" name="" value="" id="courseId">
                                    <input type="hidden" name="" value="{{ $documentsByCourse }}"
                                        id="documentsBycourse">
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
                                                <label>{{ $files[$i]->name }}
                                                </label>
                                                <div><label id="{{ 'labelFileId' . $files[$i]->id }}"> </label></div>
                                                <input class='form-control form-control-file target' type='file'
                                                    id='{{ $files[$i]->name . '-' . $files[$i]->id }}' value=''
                                                    onchange='showname(this);' data-id='{{ $files[$i]->id }}'
                                                    name='docFiles[]' data-name="{{ $files[$i]->name }}"
                                                    autofocus='autofocus'>
                                                <input id='fileid' name='fileid[]' type='hidden'
                                                    value='{{ $files[$i]->id }}'>
                                                @foreach ($employee->files as $employeeFile)
                                                    @if ($employeeFile->file_id == $files[$i]->id)
                                                        @if (file_exists(storage_path('app/' . $employeeFile->fileroute)))
                                                            {{-- <a class='btn btn-primary btn-sm mt-1' return false;' id='userFile"+item.id+"' style='margin-left: 5%'>Ver documento</a> --}}
                                                            <button class='btn btn-primary  mt-1' return false;
                                                                id="btnFile"
                                                                onclick="downloadFiles({{ $employeeFile->id }})">Ver
                                                                Documento</button>
                                                            <label style="color: red">Este documento ya esta
                                                                cargado.</label>
                                                            <div style="display: none"
                                                                id="{{ 'file-' . $employeeFile->id }}"></div>
                                                        @endif
                                                    @endif
                                                @endforeach
                                                {{-- <input id='documentTypes' type='hidden' value="{{$files}}"> --}}
                                            </div>
                                        </div>
                                    @endfor
                                    <input type="hidden" name="" id="employeeFiles"
                                        value="{{ $employee->files }}">


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
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Guardar Empleado') }}
                                    </button>
                                    <a class="btn btn-danger" href="{{ url('/getEmployee') }}">Regresar</a>
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
