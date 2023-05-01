<table>
    <thead>
    <tr>
        @for ($i = 1; $i <= $courseEnrollment->courseDays->count(); $i++)
        <th rowspan="2">{{'DIA '.$i}}</th>   
        @endfor
        <th rowspan="2" style="background-color: lightblue;">EMPRESA</th>
        <th rowspan="2">NOMBRE</th>
        <th rowspan="2">CEDULA</th>
        <th rowspan="2">FECHA DE NACIMIENTO</th>
        <th rowspan="2">CURSO</th>
        <th colspan="5">REQUISITOS</th>
        <th rowspan="2">NIVEL EDUCATIVO</th>
        <th rowspan="2">CARGO</th>
        <th rowspan="2">C EMERGENCIA</th>
        <th rowspan="2">TELEFONO</th>
        <th rowspan="2">VALOR COBRADO</th>
        <th rowspan="2">FACTURA</th>
        <th rowspan="2">OBSERVACIONES</th>
        <th rowspan="2">CERTIFICADO</th>
    </tr>
    </thead>
    <tbody>
    <tr></tr>
    @for ($j = 0; $j < $courseEnrollment->employeeEnrollment->count(); $j++)
        @if (isset($courseEnrollment->employeeEnrollment[$j]->employee))
            
       
        <tr>
            @if ($courseEnrollment->employeeEnrollment[$j] != null)
                
            
            @for ($k = 0; $k < $courseEnrollment->courseDays->count(); $k++)
            <td>{{''}}</td>   
            @endfor
            <td>{{ $courseEnrollment->employeeEnrollment[$j]->employee->company->company_name}}</td>
            <td>{{ $courseEnrollment->employeeEnrollment[$j]->employee->user->name.' '.$courseEnrollment->employeeEnrollment[$j]->employee->user->last_name}}</td>
            <td>{{ $courseEnrollment->employeeEnrollment[$j]->employee->user->identification_number}}</td>
            <td>{{$courseEnrollment->employeeEnrollment[$j]->employee->birthdate}}</td>
            <td>{{ $courseEnrollment->course->name}}</td>
            
            @for ($l = 0; $l < 5; $l++)
            
            @if($l == 4)
                <td>{{$courseEnrollment->employeeEnrollment[$j]->employee->user->hemo_classification}}</td>
            @else
                <td>{{'1'}}</td>
            @endif
            @endfor
            
            <td>{{ $courseEnrollment->employeeEnrollment[$j]->employee->academicDegree->name}}</td>
            <td>{{ $courseEnrollment->employeeEnrollment[$j]->employee->position}}</td>
            <td>{{ $courseEnrollment->employeeEnrollment[$j]->employee->emergency_contact_name}}</td>
            <td>{{ $courseEnrollment->employeeEnrollment[$j]->employee->emergency_phone_number}}</td>
           {{-- <td>{{ $courseEnrollment->employeeEnrollment[$j]}}</td> --}}
           @endif
        </tr> 
        @endif
    @endfor
    </tbody>
</table>