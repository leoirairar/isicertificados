
    <div class="col-md-12 mt-5">
            <a href="{{url('createMinistryDocument/'.$finishedEmployees[0]->course_programming_id)}}" class="btn btn-success">Generar documento del ministerio</a>
     </div>
    <table class="table table-striped table-hover mt-5" id="finishTable">
        <thead>
            <th>Nombre</th>
            <th>Cedula</th>
            <th>Nivel</th>
            <th>Fecha</th>
            <th>Entrenador</th>
            <th>Empresa</th>
        </thead>
        <tbody>
            @foreach ($finishedEmployees as $finishedEmployee)                     
            <tr>
                <td>{{$finishedEmployee->full_name}}</td>
                <td>{{$finishedEmployee->identification_number}}</td>
                <td>{{$finishedEmployee->course_name}}</td>
                <td>{{\Carbon\Carbon::parse($finishedEmployee->end_date)->format('d-m-Y')}}</td>
                <td>{{$finishedEmployee->instructor_name}}</td>
                <td>{{$finishedEmployee->company_name}}</td>
            </tr>
            @endforeach 
        </tbody>
    </table>
