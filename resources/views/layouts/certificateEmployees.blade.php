<table class="table table-striped table-hover mt-5" id="finishTable">
        <thead>
            <th></th>
            <th>Cedula</th>
            <th>Nombre</th>
            <th>Empresa</th>
            <th>curso</th>
            <th>Pagó</th>
            <th>Certificado</th>
        </thead>
        <tbody>
            @foreach ($employeesCertificateByCourse as $employeeCertificateByCourse)                     
            <tr>
                <td></td>                    
                <td>{{$employeeCertificateByCourse->identification}}</td>                    
                <td>{{$employeeCertificateByCourse->employee_name." ".$employeeCertificateByCourse->employee_last_name}}</td>
                <td>{{$employeeCertificateByCourse->company_name}}</td>
                <td>{{$employeeCertificateByCourse->course_name}}</td>
                <td>{{($employeeCertificateByCourse->payment_status == 1)?'Pagó':'No pagó'}}</td>
                @if ($employeeCertificateByCourse->payment_status == 1)
                    <td>
                        <a href="{{url('viewCertificate/'.$employeeCertificateByCourse->course_enrollment_id)}}" target="_blank" class="btn btn-success">Generar Certificado</a>
                    </td>
                @endif
            </tr>
            @endforeach 
        
        </tbody>
    </table> 