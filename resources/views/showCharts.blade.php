@extends('layouts.app')

@section('content')

{{-- espacio para un grafico Cantidad de suarios certificados entre dos fechas--}}
<div class="">
    <div class="">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="font-weight: bold">Cantidad de empleados certificados entre dos fechas</div>
                <div class="card-body">
                    <div class="d-flex flex-column ml-5">
                        <div class="row ">
                            <div class="input-group date col-md-4" id="chartdatetimepicker3" data-target-input="nearest">
                                <input type="text"  id="begin_date3" class="form-control datetimepicker-input @error('begin_date3') is-invalid @enderror" data-target="#chartdatetimepicker3" name="begin_date3" value="{{ old('begin_date3') }}" required autocomplete="begin_date3" autofocus/>
                                <div class="input-group-append" data-target="#chartdatetimepicker3" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                            <div class="input-group date col-md-4" id="chartdatetimepicker4" data-target-input="nearest">
                                <input type="text" id="end_date4"  class="form-control datetimepicker-input @error('end_date4') is-invalid @enderror" data-target="#chartdatetimepicker4" name="end_date4" value="{{ old('end_date4') }}" required autocomplete="end_date4" autofocus/>
                                <div class="input-group-append" data-target="#chartdatetimepicker4" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="btn btn-primary" id="certificatesUsersBetweenDates">filtrar</div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">    
                                <select class="form-control " id="company2" name="company2"  required autocomplete="current-company2">
                                    <option value="">Selecciona una opción</option>
                                    @foreach ($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->company_name}}</option>  
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select class="form-control " id="course2" name="course2"  required autocomplete="current-course2">
                                    <option value="">Selecciona una opción</option>
                                    @foreach ($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->name.' '.$course->course_code}}</option>  
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                        <div class="row mt-">
                            <div class="col-md-8 mt-5" id="">
                                <canvas id="contentCertificatesByDates" style="width: 30%"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- espacio para un grafico Cantidad de suarios certificados entre dos fechas--}}
<div class="">
    <div class="">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="font-weight: bold">Cantidad de empleados certificados vs no certificados entre dos fechas</div>
                <div class="card-body">
                    <div class="d-flex flex-column ml-5">
                        <div class="row ">
                            <div class="input-group date col-md-4" id="chartdatetimepicker5" data-target-input="nearest">
                                <input type="text"  data-date-format="dd MM yyyy" id="begin_date5" class="form-control datetimepicker-input @error('begin_date5') is-invalid @enderror" data-target="#chartdatetimepicker5" name="begin_date5" value="{{ old('begin_date5') }}" required autocomplete="begin_date5" autofocus/>
                                <div class="input-group-append" data-target="#chartdatetimepicker5" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                            <div class="input-group date col-md-4" id="chartdatetimepicker6" data-target-input="nearest">
                                <input type="text" id="end_date6"  class="form-control datetimepicker-input @error('end_date6') is-invalid @enderror" data-target="#chartdatetimepicker6" name="end_date6" value="{{ old('end_date6') }}" required autocomplete="end_date6" autofocus/>
                                <div class="input-group-append" data-target="#chartdatetimepicker6" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="btn btn-primary" id="btnCertificatesUncerEmployees">filtrar</div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">    
                                <select class="form-control " id="company3" name="company3"  required autocomplete="current-company3">
                                    <option value="">Selecciona una opción</option>
                                    @foreach ($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->company_name}}</option>  
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select class="form-control " id="course3" name="course3"  required autocomplete="current-course3">
                                    <option value="">Selecciona una opción</option>
                                    @foreach ($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->name.' '.$course->course_code}}</option>  
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                        <div class="row mt-">
                            <div class="col-md-8 mt-5" id="">
                                <canvas id="certificatesUncerEmployees" style="width: 30%"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- espacio para un grafico Cantidad de suarios por curso --}}
<div class="">
    <div class="">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="font-weight: bold">Cantidad de empleados matriculados por curso</div>
                <div class="card-body">
                    <div class="d-flex flex-column ml-5">
                        <div class="row ">
                            <div class="input-group date col-md-4" id="chartdatetimepicker7" data-target-input="nearest">
                                <input type="text"  data-date-format="dd MM yyyy" id="begin_date7" class="form-control datetimepicker-input @error('begin_date7') is-invalid @enderror" data-target="#chartdatetimepicker7" name="begin_date7" value="{{ old('begin_date7') }}" required autocomplete="begin_date7" autofocus/>
                                <div class="input-group-append" data-target="#chartdatetimepicker7" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                            <div class="input-group date col-md-4" id="chartdatetimepicker8" data-target-input="nearest">
                                <input type="text" id="end_date8"  class="form-control datetimepicker-input @error('end_date8') is-invalid @enderror" data-target="#chartdatetimepicker8" name="end_date8" value="{{ old('end_date8') }}" required autocomplete="end_date8" autofocus/>
                                <div class="input-group-append" data-target="#chartdatetimepicker8" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="btn btn-primary" id="btnCertificatesEmployeesByCurse">filtrar</div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">    
                                <select class="form-control " id="company4" name="company4"  required autocomplete="current-company4">
                                    <option value="">Selecciona una opción</option>
                                    @foreach ($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->company_name}}</option>  
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select class="form-control " id="course4" name="course4"  required autocomplete="current-course4">
                                    <option value="">Selecciona una opción</option>
                                    @foreach ($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->name.' '.$course->course_code}}</option>  
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                        <div class="row mt-">
                            <div class="col-md-8 mt-5" id="">
                                <canvas id="certificatesEmployeesByCurse" style="width: 30%"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script src="{{ asset('js/app/statistics.js') }}"></script>
<script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('js/tempusdominus-bootstrap-4.min.js') }}"></script>

@endsection