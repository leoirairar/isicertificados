
<form method="POST" action="{{ route('saveAttendanceCourse') }}">
@csrf 
<div class="mt-2">
    <div class="row mb-2">
        <div class="col-sm-2 border-bottom">Nombre</div>
        <div class="col-sm-3 border-bottom">Empresa</div>
        <div class="col-sm-2 border-bottom">curso</div>
        <div class="col-sm-2 border-bottom">Asistencia</div>
        <div class="col-sm-3 border-bottom">Grupo</div>
    </div>
    @for ($i = 0; $i < $courseEnrollment->employeeEnrollment->count(); $i++)
    @if (isset($courseEnrollment->employeeEnrollment[$i]->employee->user))
    <div class="row mb-2">
        <div class="col-md-2  border-bottom">{{$courseEnrollment->employeeEnrollment[$i]->employee->user->name.' '.$courseEnrollment->employeeEnrollment[$i]->employee->user->last_name}}</div>
        <div class="col-md-3  border-bottom">{{$courseEnrollment->employeeEnrollment[$i]->employee->company->company_name}}</div>
        <div class="col-md-2  border-bottom">{{$courseEnrollment->course->name}}</div>
        <input type="hidden" required name="courseProgrammingId" id="grade" data-placement="top" value="{{$courseEnrollment->id}}">
        <div class="col-md-2  border-bottom">
            
                <input type="hidden" required name="employee[{{"employee".$courseEnrollment->employeeEnrollment[$i]->id}}][enrollmentId]" id="grade" data-placement="top" value="{{$courseEnrollment->employeeEnrollment[$i]->id}}">
                <div class=" form-check-inline">
                  <input class="form-check-input" required type="radio"  {{($courseEnrollment->employeeEnrollment[$i]->cancel !== null ? (($courseEnrollment->employeeEnrollment[$i]->cancel === 0) ? 'checked' : '' ):'')}} name="employee[{{"employee".$courseEnrollment->employeeEnrollment[$i]->id}}][attendance]" id="inlineRadio1" value="1">
                  <label class="form-check-label" for="inlineRadio1">Si</label>
                </div>
                <div class="form-check-inline">
                  <input class="form-check-input" required type="radio" {{($courseEnrollment->employeeEnrollment[$i]->cancel !== null ? (($courseEnrollment->employeeEnrollment[$i]->cancel == 1) ? 'checked' : '' ):'checked')}}   name="employee[{{"employee".$courseEnrollment->employeeEnrollment[$i]->id}}][attendance]" id="inlineRadio2" value="0">
                  <label class="form-check-label" for="inlineRadio2">No</label>
                </div>
           
        </div>
        <div class="col-md-3 border-bottom">
            <select class=" form-control  " style="margin-bottom: 10px;"  name="employee[{{"employee".$courseEnrollment->employeeEnrollment[$i]->id}}][group]" id="group">
                <option value="0" {{($courseEnrollment->group == 0)?'selected':''}} >Na.</option>
                <option value="1" {{($courseEnrollment->group == 1)?'selected':''}}>Grupo 1</option>
                <option value="2" {{($courseEnrollment->group == 2)?'selected':''}}>Grupo 2</option>
                <option value="3" {{($courseEnrollment->group == 3)?'selected':''}}>Grupo 3</option>
                <option value="4" {{($courseEnrollment->group == 4)?'selected':''}}>Grupo 4</option>
            </select>
        </div>
    </div> 
    @endif
    @endfor
</div>
    @if ($courseEnrollment->employeeEnrollment->count() > 0)
    <div class=" row mt-3  mb-3">
            <div id="btnSave" class="col-md-12 ">
                <button  type="submit" class="btn btn-primary">
                    {{ __('Guardar asistencia') }}
                </button>
            </div>
    </div>
    
</div>
    @else
    <div class="alert alert-danger" role="alert">
           No hay empleados registrados en este curso !
    </div>

    @endif
</form>