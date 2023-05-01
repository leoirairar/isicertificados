@php
    setlocale(LC_ALL,'es_ES.UTF-8');
@endphp
@if ($collectionUser != null)
<table class="table table-striped table-hover mt-5" style="font-family: Poppins, sans-serif;"  id="finishTable">
    <thead>
        <th>Nombre</th>
        <th>Curso</th>
        <th>Fechas</th>
        <th>Descargar constancia de asistencia</th>
    </thead>
    <tbody>
       
            @foreach ($collectionUser as $user)
            <tr>
                {{-- <td>{{$user['identification']}}</td> --}}
                <td>{{$user['name']}}</td>
                <td>{{$user['course']}}</td>
                <td>{{$user['date']}}</td>
                @if (!$user['historical'])
                    <td>
                         <a href="{{url('viewAttedanceCertificate/'.$user['id'])}}" class="btn btn-success">Generar constancia</a> 
                    </td>
                @else
                    <td>
                         <a href="{{url('viewAttedanceCertificateHistorical/'.$user['id'])}}" class="btn btn-success">Generar constancia</a> 
                    </td>
                @endif
            </tr>
            @endforeach
        
        {{-- @for($i = 0; $i < $collectionUser->count(); $i++)                   
            @for($j = 0; $j < count($collectionUser[$i]); $j++)                   
            <tr>         
                <td>{{$collectionUser[$i][0]}}</td>
                <td>{{$collectionUser[$i][1]}}</td>
                <td>
                        {{-- <a href="{{url('viewAttedanceCertificate/'.$enrollment->id)}}" class="btn btn-success">Generar Certificado</a> 
                </td>
            </tr>
            @endfor   
        @endfor    --}}
    </tbody>
</table> 
@else
<div class="alert alert-danger" role="alert">
    No se encuentra este numero de cedula asociado a algún curso ¡¡
  </div>       
@endif