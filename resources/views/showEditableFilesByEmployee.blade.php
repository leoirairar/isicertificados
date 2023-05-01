@extends('layouts.app') 
@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-12">
         <div class="card shadow ">
            <div class="card-header" style="font-weight: bold">{{$employee->user->name.' '.$employee->user->last_name}}</div>
            @if (session('error'))
               <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="card-body">
               <form method="POST" action="{{ route('updateCourseAssignmentFiles') }}" enctype="multipart/form-data">
               @csrf
               @method('put') 
               <input id="prodId" name="enrollment_id" type="hidden" value="{{$enrollment->id}}">
               <input id="prodId" name="coursePrograming_id" type="hidden" value="{{$enrollment->course_programming_id}}">
               <input id="prodId" name="employee_id" type="hidden" value="{{$enrollment->employee_id}}">
               <input id="prodId" name="course_id" type="hidden" value="{{$course->id}}">
               <div class="py-5 text-center">
                  <h1>{{$employee->user->name.' '.$employee->user->last_name}}</h1>
               </div>
               <div class="row">
                  <div class="col-md-6 order-md-1 pl-5">
                
                     <div data-type="default" class="row">
                        <div data-type="default" class="col-md-8 mb-3">
                           <label for="firstName">Nombre de la empresa</label>
                           <input data-type="default" typNombree="text" id="companyName" placeholder="" readonly value="{{$employee->company->company_name}}" required="" class="form-control">
                        </div>
                    </div>
                    <div data-type="default" class="row">
                        <div data-type="default" class="col-md-8 col-sd-6 mb-3">
                           <label for="Employee">Empleado</label>
                           <input data-type="default" type="text" id="userName" placeholder="" readonly value="{{$employee->user->name.' '.$employee->user->last_name}}" required="" class="form-control">
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6 order-md-2 mb-4">
                     <div data-type="default" class="row">
                            <div data-type="default" class="col-md-8 col-sd-6 mb-3">
                               <label for="Employee">Curso</label>
                               <input data-type="default" type="text" id="coruseName" placeholder="" readonly value="{{$course->name}}" required="" class="form-control">
                               <input id="courseId" type="hidden" value="{{$course->id}}">
                            </div>
                         </div>
                  </div>
               </div>
               <hr>
               <div class="row">
                   <div class="col-md-7 pt-4 pl-5 pb-5">
                        <h4 data-type="header" class="d-flex justify-content-between align-items-center mb-3">
                                <span>Adjuntar documentos</span> 
                        </h4>
                        <div class="attachment" id="attachment">
                        </div>         
                   </div>
                   <div class="col-md-4 pt-4 pl-5 pb-5">  
                        <h4 data-type="header" class="d-flex justify-content-between align-items-center mb-3">
                                <span>Notificaciones</span> 
                                
                        </h4>    
                        <div class="overflow-auto">
                              <ul class="list-group mt-3" id="attachedDocuments">
                                    {{-- <li class="list-group-item">hola</li>
                                    <li class="list-group-item">hola2</li> --}}
                                 </ul>
                           </div>  
                   </div>
               </div>
               
               <div class="form-group row mb-0">
                     <div class="col-md-8 offset-md-8">
                         <button type="submit" class="btn btn-primary" id="sendButton" disabled>
                             {{ __('Guardar documento') }}
                         </button>
                         <a class="btn btn-danger " href="{{url('getCompanyInformation/'.$companyId)}}" role="button">Regresar</a>
                     </div>

                 </div>
             </form>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@include ('footer') 
@section('scripts')
@routes
<script src="{{ asset('js/app/editFiles.js') }}"></script>
@endsection

