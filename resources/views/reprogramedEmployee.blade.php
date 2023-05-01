@extends('layouts.app')

@section('content')
        <div class="">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="font-weight: bold">Reprogramar empleado</div>
                    <div class="card-body">
                        <table class="table table-striped table-hover" id="rescheduleTable">
                            <thead>
                                <th>Nombre</th>
                                <th>otros datos</th>
                                <th>Curso a reprogramar</th>
                                <th>Nuevas fechas disponibles</th>
                                <th>Reprogramar</th>
                            </thead>
                            <tbody>
                                @foreach ($rescheduleEmployees as $rescheduleEmployee)
                                
                                    <tr id="{{'trrescheduleEmployee'.$rescheduleEmployee->courseProgramming->id}}">
                                        @isset($rescheduleEmployee->employee->user)
                                        <input type="hidden" name="coursePrograminId" class="coursePrograminId" id="coursePrograminId" value="{{$rescheduleEmployee->courseProgramming->id}}">
                                        <td>{{$rescheduleEmployee->employee->user->name}} {{$rescheduleEmployee->employee->user->last_name}}</td>
                                        <td></td>
                                        <td>{{$rescheduleEmployee->courseProgramming->course->name.' '.\Carbon\Carbon::parse($rescheduleEmployee->courseProgramming->begin_date)->format('Y-m-d')}}</td>
                                        <td>
                                            <select class="form-control" id="{{'avaibleCourses'.$rescheduleEmployee->courseProgramming->id}}" name="{{'avaibleCourses'.$rescheduleEmployee->courseProgramming->id}}"  required autocomplete="current-avaibleCourses">
                                                <option value="">Selecciona una opción</option>
                                                @foreach ($avaibleCourses as $avaibleCourse)
                                                    @foreach($avaibleCourse as $programmedCourse)
                                                        @if ($programmedCourse->course_id == $rescheduleEmployee->courseProgramming->course_id)

                                                        <option value="{{ $programmedCourse->id }}">{{ $programmedCourse->course->name.' - inicio '.\Carbon\Carbon::parse($programmedCourse->begin_date)->format('Y-m-d')}}</option>

                                                        @endif 
                                                   @endforeach 
                                                @endforeach
                                               
                                            </select>
                                         </td>   
                                        <td width="10px">
                                            <button class="btn btn-primary" id="rescheduleButton" onclick="reprogram({{$rescheduleEmployee->courseProgramming->id}},{{$rescheduleEmployee->employee->id}})">Reprogramar</button>
                                        </td>
                                        @endisset
                                    </tr>
                                   
                                @endforeach 
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
@endsection
@section('scripts')
<script src="{{ asset('js/app/reschedule.js') }}"></script>
@endsection