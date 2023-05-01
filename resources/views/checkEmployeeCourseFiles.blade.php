@extends('layouts.app')

@section('content')
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header" style="font-weight: bold">Evaluar documentos</div>
                    @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <div class="card-body">
                        <form method="post" action="{{ route('updateFilesState') }}">
                            @csrf 
                            @method('post')

                        @if ($enrollment != null)
                            
                        
                        
                        @foreach ($courseFiles->documentsType as $courseDocument)
                        <input id="prodId" name="enrollment_id" type="hidden" value="{{$enrollment->id}}">
                        <input id="prodId" name="coursePrograming_id" type="hidden" value="{{$enrollment->course_programming_id}}">
                        <input id="prodId" name="employee_id" type="hidden" value="{{$enrollment->employee_id}}">
                        <div class="d-flex bd-highlight mt-4">
                            <div class="flex-even"><span>{{$courseDocument->name}}</span></div>
                            <div class="flex-even">
                                @php
                                 $showed = false;
                                 $empty = true; 
                                 $userFileId = null;
                                 $fileStatus = "";  
                                @endphp
                                @if (count($files) > 0)
                                @foreach ($files as $file)
                                    @if($showed == false)
                                        @if ($courseDocument->id == $file->file_id)
                                            <a id='fileDownload' class="mr-2" href="{{route('file',[$file->id])}}" >Descargar documento</a>
                                            @php
                                                $empty = false;  
                                                $showed = true;
                                                $userFileId = $file->id;
                                                $fileStatus = $file->status;
                                            @endphp                                            
                                        @endif 
                                    @endif
                                    
                                @endforeach
                                @if ($empty)
                                    <i class=''>No se han subido documentos</i>
                                @endif
                                @else
                                    <i class=''>Al empleado no se le han subido documentos</i>
                                @endif
                            </div>
                            <div class=" flex-even ">
                                <i class="list-inline-item" >
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input name="radio{{$courseDocument->id}}[{{"file".$userFileId}}][status]" id="radio{{$courseDocument->id}}_0" type="radio" {{($fileStatus=="A")?'checked':''}} required class="custom-control-input" value="A"> 
                                        <input id="prodId" name="radio{{$courseDocument->id}}[{{"file".$userFileId}}][file_id]" type="hidden" value="{{$userFileId}}">
                                        <input id="" name="radio{{$courseDocument->id}}[{{"file".$userFileId}}][courseDocument_id]" type="hidden" value="{{$courseDocument->id}}">
                                        <label for="radio{{$courseDocument->id}}_0" class="custom-control-label">Aprobado</label>
                                    </div>
                                </i>
                            </div>
                            <div class=" flex-even ">
                                <i class="list-inline-item" >
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input name="radio{{$courseDocument->id}}[{{"file".$userFileId}}][status]" id="radio{{$courseDocument->id}}_1" type="radio" {{($fileStatus=="E")?'checked':''}} required  class="custom-control-input" value="E"> 
                                        <input id="prodId" name="radio{{$courseDocument->id}}[{{"file".$userFileId}}][file_id]" type="hidden" value="{{$userFileId}}">
                                        <input id="" name="radio{{$courseDocument->id}}[{{"file".$userFileId}}][courseDocument_id]" type="hidden" value="{{$courseDocument->id}}">
                                        <label for="radio{{$courseDocument->id}}_1" class="custom-control-label">Falta Documento</label>
                                    </div>
                                </i>
                            </div>
                            <div class=" flex-even ">
                                <i class="list-inline-item" >
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input name="radio{{$courseDocument->id}}[{{"file".$userFileId}}][status]" id="radio{{$courseDocument->id}}_2" type="radio" required {{($fileStatus=="W")?'checked':''}} class="custom-control-input" value="W"> 
                                        <input id="prodId" name="radio{{$courseDocument->id}}[{{"file".$userFileId}}][file_id]" type="hidden" value="{{$userFileId}}">
                                        <input id="" name="radio{{$courseDocument->id}}[{{"file".$userFileId}}][courseDocument_id]" type="hidden" value="{{$courseDocument->id}}">
                                        <label for="radio{{$courseDocument->id}}_2" class="custom-control-label">Documento con errores</label>
                                    </div>
                                </i>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div class="alert alert-danger">Este curso se ha deshabilitado</div>
                        @endif
                    </div>
                    <div  class="d-flex flex-row-reverse bd-highlight mr-5 mb-4 mt-3">
                        <a class="btn btn-danger ml-1" href="{{ url('/EnrolledEmployees') }}">Regresar</a>
                        <button type="submit" class="btn btn-primary">Guardar criterios</button>
                        
                    </form>   
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
{{-- <script src="{{ asset('js/app/#.js') }}"></script> --}}
@endsection

