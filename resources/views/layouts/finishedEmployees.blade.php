   
 @if ($finishedEmployees->count() == 0)
 <div class="alert alert-danger mt-5" role="alert">
    Este curso aun no posee empleados inscritos!
</div>
 @else
 <form method="POST" action="{{ route('insertCertificateGrade') }}">
    @csrf 
    <input id="" name="company_id" type="hidden" value="{{$finishedEmployees[0]->employee->company->id}}">
    @if ($instructors->count() != 0)
    <div class="col-sm-6 mt-5">
        <label for="position" class="col-md-4 col-form-label">{{ __('Instructor') }}</label>
        <input type="hidden" name="courseInstructorId" value="{{($finishedEmployees[0]->courseProgramming->courseInstructor->count() != 0) ?$finishedEmployees[0]->courseProgramming->courseInstructor[0]->id:""}}">
        <select class="form-control " name="instructorId" id="instructorId" required>
            <option value=''>Por favor seleccione un instructor</option>
            @foreach ($instructors as $instructor)
            <option value="{{ $instructor->id }}" {{($finishedEmployees[0]->courseProgramming->courseInstructor->count() != 0)?(($finishedEmployees[0]->courseProgramming->courseInstructor[0]->instructor_id == $instructor->id)?'selected':"") :''}}>{{ $instructor->user->name.' '.$instructor->user->last_name}}</option>
            @endforeach
        </select> 
    </div>
    <div class="col-sm-6 mt-2">
            <label for="position" class="col-md-4 col-form-label">{{ __('Supervisor') }}</label>
            <input type="hidden" name="courseSupervisorId" value="{{($finishedEmployees[0]->courseProgramming->courseInstructor->count() != 0)?$finishedEmployees[0]->courseProgramming->courseInstructor[1]->id:""}}">
            <select class="form-control " name="supervisorId" id="supervisorId" required>
                <option value="">Por favor seleccione un supervisor</option>
                @foreach ($instructors as $instructor)
                <option value="{{ $instructor->id }}" {{($finishedEmployees[0]->courseProgramming->courseInstructor->count() != 0)?(($finishedEmployees[0]->courseProgramming->courseInstructor[1]->instructor_id == $instructor->id)?'selected':"") :''}}>{{ $instructor->user->name.' '.$instructor->user->last_name }}</option>
                @endforeach
            </select> 
        </div>        
    @else
        <div class="alert alert-danger mt-5" role="alert">
           No hay instructores inscritos, por favor registre los instructores para poder continuar. ¡
        </div>
    @endif

<div class=" mt-3 border" id="FinishTableParent" >
        <div class="finishTableContainer" style="width: 120%; min-width:1200px;">
        <input type="hidden" name="programmedCourseId" value="{{$finishedEmployees[0]->courseProgramming->id}}" >
    @for ($i = 0; $i < $finishedEmployees->count(); $i++)
    @if ($finishedEmployees[$i]->employee != null)
    @if ($i == 0)
     <div class="finishCourseTableHeader">
        <div class="font-weight-bold"><label for="#">Nombre</label></div>
        <div class="font-weight-bold"><label for="#">Empresa</label></div>
        @foreach ($finishedEmployees[$i]->courseProgramming->courseDays as $item)
        <div class="font-weight-bold"><label for="#">{{\Carbon\Carbon::parse($item->date)->format('d-m-Y')}}</label></div>
        @endforeach
        <div class="font-weight-bold"><label for="#">Aprobó</label></div>
        <div class="font-weight-bold"><label for="#">Pago</label></div>
        <div class="font-weight-bold"><label for="#">N° Factura</label></div>
        {{-- <div class="font-weight-bold"><label for="#">Nota</label></div> --}}
        <div class="font-weight-bold"><label for="#">Observaciones</label></div>
        {{-- <div class="font-weight-bold"><label for="#">Valor</label></div> --}}
        
        
        
    </div>   
    @endif
    <div class="finishCourseTableRow" >
        <input type="hidden" name="employee[{{"employee".$finishedEmployees[$i]->id}}][courseProgrammingId]" value="{{$finishedEmployees[$i]->courseProgramming->id}}" >
        <input type="hidden" name="employee[{{"employee".$finishedEmployees[$i]->id}}][enrollmentId]" value="{{$finishedEmployees[$i]->id}}" >
        <div class="border-bottom">{{$finishedEmployees[$i]->employee->user->name." ".$finishedEmployees[$i]->employee->user->last_name }}</div>
        <div class="border-bottom">{{$finishedEmployees[$i]->employee->company->company_name}}</div>
         @for ($j = 0; $j < $finishedEmployees[$i]->courseProgramming->courseDays->count(); $j++) {{--for de los dias del curso --}}
        @if ( $finishedEmployees[$i]->attendanceDay->count() == 0)
            <div class="border-bottom">
                <input type="hidden" required name="employee[{{"employee".$finishedEmployees[$i]->id}}][attendance][{{"attendance".$j}}][courseDayId]" id="grade" data-placement="top" value="{{$finishedEmployees[$i]->courseProgramming->courseDays[$j]->id}}">
                <div class=" form-check-inline">
                  <input class="form-check-input" required type="radio" name="employee[{{"employee".$finishedEmployees[$i]->id}}][attendance][{{"attendance".$j}}][value]" id="inlineRadio1" value="1" checked>
                  <label class="form-check-label" for="inlineRadio1">Si</label>
                </div>
                <div class="form-check-inline">
                  <input class="form-check-input" required type="radio" name="employee[{{"employee".$finishedEmployees[$i]->id}}][attendance][{{"attendance".$j}}][value]" id="inlineRadio2" value="0">
                  <label class="form-check-label" for="inlineRadio2">No</label>
                </div>
            </div>     
        @else
            @php
            $check = false;
            @endphp
            @for ($k = 0; $k < $finishedEmployees[$i]->attendanceDay->count(); $k++){{--for de la asistencia del empleado --}}
                @if ($finishedEmployees[$i]->attendanceDay[$k]->pivot->course_day_id == $finishedEmployees[$i]->courseProgramming->courseDays[$j]->id)
                <div class="border-bottom" style="width: 120px;">
                    <input type="hidden" checked required name="employee[{{"employee".$finishedEmployees[$i]->id}}][attendance][{{"attendance".$j}}][courseDayId]" id="grade" data-placement="top" value="{{$finishedEmployees[$i]->courseProgramming->courseDays[$j]->id}}">
                    <input type="hidden" required name="employee[{{"employee".$finishedEmployees[$i]->id}}][attendance][{{"attendance".$j}}][id]" id="grade" data-placement="top" value="{{($finishedEmployees[$i]->attendanceDay[$k]->pivot != null)?$finishedEmployees[$i]->attendanceDay[$k]->pivot->id:""}}">
                    <div class=" form-check-inline">
                      <input class="form-check-input" required type="radio" name="employee[{{"employee".$finishedEmployees[$i]->id}}][attendance][{{"attendance".$j}}][value]" id="inlineRadio1" value="1" checked>
                      <label class="form-check-label" for="inlineRadio1">Si</label>
                    </div>
                    <div class="form-check-inline">
                      <input class="form-check-input" required type="radio" name="employee[{{"employee".$finishedEmployees[$i]->id}}][attendance][{{"attendance".$j}}][value]" id="inlineRadio2" value="0">
                      <label class="form-check-label" for="inlineRadio2">No</label>
                    </div>
                </div>
                @php
                $check = true;
                @endphp
                @endif               
            @endfor
            @if ($check == false)
            <div class="border-bottom" style="width: 120px;">
                    <input type="hidden" checked required name="employee[{{"employee".$finishedEmployees[$i]->id}}][attendance][{{"attendance".$j}}][courseDayId]" id="grade" data-placement="top" value="{{$finishedEmployees[$i]->courseProgramming->courseDays[$j]->id}}">
                    <div class=" form-check-inline">
                  <input class="form-check-input" required type="radio" name="employee[{{"employee".$finishedEmployees[$i]->id}}][attendance][{{"attendance".$j}}][value]" id="inlineRadio1" value="1" >
                  <label class="form-check-label" for="inlineRadio1">Si</label>
                </div>
                <div class="form-check-inline">
                  <input class="form-check-input" required type="radio" name="employee[{{"employee".$finishedEmployees[$i]->id}}][attendance][{{"attendance".$j}}][value]" id="inlineRadio2" value="0" checked>
                  <label class="form-check-label" for="inlineRadio2">No</label>
                </div> 
            </div>
            @endif
        @endif
        
        @endfor
        <div class="border-bottom" style="width: 120px;">
            <select class=" form-control  " required name="employee[{{"employee".$finishedEmployees[$i]->id}}][statement]" id="status">
                <option value="1" {{($finishedEmployees[$i]->certificate != null)?(($finishedEmployees[$i]->certificate->statement == 1)?"selected":" "):" "}}>Si</option>
                <option value="0" {{($finishedEmployees[$i]->certificate != null)?(($finishedEmployees[$i]->certificate->statement == 0)?"selected":" "):" "}}>No</option>
                <option value="2" {{($finishedEmployees[$i]->reschedule != null)?(($finishedEmployees[$i]->reschedule == 1)?"selected":" "):" "}}>Reprogramar</option>
            </select>
        </div>
        <div class="border-bottom">
            <select class=" form-control  "  name="employee[{{"employee".$finishedEmployees[$i]->id}}][billStatus]" id="status">
                <option value="1" {{($finishedEmployees[$i]->bill != null)?(($finishedEmployees[$i]->bill->payment_status == 1)?"selected":" "):" "}} >Si</option>
                <option value="0" {{($finishedEmployees[$i]->bill != null)?(($finishedEmployees[$i]->bill->payment_status == 0)?"selected":" "):"selected"}}>No</option>
            </select>
        </div>
        <input type="hidden" name="employee[{{"employee".$finishedEmployees[$i]->id}}][certificateId]" value="{{($finishedEmployees[$i]->certificate != null)?$finishedEmployees[$i]->certificate->id:" "}}" >
        <div class="border-bottom" style="width: 11%;">
            <input type="hidden" name="employee[{{"employee".$finishedEmployees[$i]->id}}][billId]" value="{{($finishedEmployees[$i]->bill != null)?$finishedEmployees[$i]->bill->id:" "}}" >
            <input class=" form-control"  type="text" name="employee[{{"employee".$finishedEmployees[$i]->id}}][bill]" id="bill" data-placement="top" value="{{($finishedEmployees[$i]->bill != null)?$finishedEmployees[$i]->bill->bill_serial:" "}}" >
        </div>
        {{-- <div class="border-bottom" style="width: 80px;">
            
            <input class=" form-control" required type="number" placeholder="1.00" step="0.1" name="employee[{{"employee".$finishedEmployees[$i]->id}}][grade]" min="0" max="5" id="grade" data-toggle="tooltip" data-placement="top" value="{{($finishedEmployees[$i]->certificate != null)?$finishedEmployees[$i]->certificate->grade:0}}">
        </div> --}}
        <div class="border-bottom">
            <input type="hidden" name="employee[{{"employee".$finishedEmployees[$i]->id}}][enrollmentId]" value="{{($finishedEmployees[$i]->id != null)?$finishedEmployees[$i]->id:" "}}" >
            <input class=" form-control" type="text" name="employee[{{"employee".$finishedEmployees[$i]->id}}][observations]"  id="observations" data-toggle="tooltip" data-placement="top" value="{{$finishedEmployees[$i]->observations}}">
        </div>
        {{-- <div class="border-bottom" style="width: 7%;">
            <input class=" form-control"  type="number" placeholder="120000" name="employee[{{"employee".$finishedEmployees[$i]->id}}][billValue]" id="grade" data-placement="top" value="{{($finishedEmployees[$i]->bill != null)?$finishedEmployees[$i]->bill->payment:" "}}">
        </div> --}}

        
    </div>
    @endif
    @endfor
    </div>
</div>
@if ($finishedEmployees->count() > 0)
@if ($instructors->count() != 0)
<div class=" row mt-3">
        <div id="btnSave" class="col-md-12 ">
            <button  type="submit" class="btn btn-primary">
                {{ __('Actualizar') }}
            </button>
        </div>
</div>    
@endif

@else
<div class="alert alert-danger" role="alert">
       No hay empleados registrados en este curso !
</div>

@endif
</form>
@endif
<script>

$(document).ready(function () {
    
    {{-- $('#instructorId').change(function (e) { 
        e.preventDefault();
        var selectedInstructor = $(this).children("option:selected").val();
        var selectedSupervisor = $('#supervisorId').children("option:selected").val();

        if (selectedSupervisor != null) {
            if (selectedInstructor == selectedSupervisor) {
                //document.getElementById("supervisorId").selectedIndex = 0;
                Swal.fire({
                type: 'error',
                title: '',
                text: 'El instructor no puede ser el mismo que el supervisor!',
            }) 
        
            
            }
        }
        
    }); --}}
{{-- 
    $('#supervisorId').change(function (e) { 
        e.preventDefault();
        var selectedInstructor = $("#instructorId").children("option:selected").val();
        var selectedSupervisor = $(this).children("option:selected").val();

        if (selectedInstructor != null) {
            if (selectedInstructor == selectedSupervisor) {
                document.getElementById("supervisorId").selectedIndex = 0;
                Swal.fire({
                type: 'error',
                title: '',
                text: 'El supervisor no puede ser el mismo que el instructor!',
            }) 
            }
        }
    }); --}}
});


</script>