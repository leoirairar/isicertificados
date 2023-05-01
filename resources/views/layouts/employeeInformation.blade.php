<div class="container">
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
    @if ($user !== null)
        <input type="hidden" name="" id="employeeId" value="{{$user->employee->id}}">
        <div class="col-sm-12 mb-3" ><span style="font-size: x-large;" >Datos empleado</span></div>
        <div class="row">
            <div class="col-sm-6">
                <label class=" text-md-right">{{ __('Nombre completo') }}</label>
                <input id="fullName" type="text" class="form-control " value="{{ $user->name." ".$user->last_name }}" disabled>
            </div>
            <div class="col-sm-6">
                <label class=" text-md-right">{{ __('Cedula') }}</label>
                <input id="identification_number" type="text" class="form-control " value="{{ $user->identification_number }}" disabled>
            </div>
            <div class="col-sm-6 mt-3">
                <label class=" text-md-right">{{ __('Número telefonico') }}</label>
                <input id="" type="text" class="form-control " value="{{ $user->phone_number }}" disabled>
            </div>
            <div class="col-sm-6 mt-3">
                <label class=" text-md-right">{{ __('Correo electronico') }}</label>
                <input id="" type="text" class="form-control " value="{{ $user->email }}" disabled>
            </div>
            <div class="col-sm-6 mt-3">
                <label class=" text-md-right">{{ __('Contacto de emergencia') }}</label>
                <input id="" type="text" class="form-control " value="{{ $user->employee->emergency_contact_name }}" disabled>
            </div>
            <div class="col-sm-6 mt-3">
                    <label class=" text-md-right">{{ __('Número telefónico contacto de emergencia') }}</label>
                    <input id="" type="text" class="form-control " value="{{ $user->employee->emergency_phone_number }}" disabled>
            </div>
        </div>
        <div class="col-sm-12 mb-3 mt-4" ><span style="font-size: x-large;" >Empresas</span></div>
        <div class="row">
            <div class="col-sm-6">
                <label class=" text-md-right">{{ __('Nombre de la empresa') }}</label>
                <input id="fullName" type="text" class="form-control " value="{{$user->employee->company->company_name }}" disabled>
                ir: <a class="mt-1" href="{{url('getCompanyInformation/'.$user->employee->company->id)}}" target="_blank" rel="noopener noreferrer">Ver informaci'on de la empresa</a>
            </div>
        </div>
        <div class="col-sm-12 mb-3 mt-3" ><span style="font-size: x-large;" >Historial de cursos</span></div>
        <div class="row" >
            <div class="table-responsive mt-5">
            <table class="table table-striped table-hover" id="employeeEnrollmentInformation" style="width:100%!important">
                <thead>
                </thead>
                <tbody>
                </tbody>
            </table>
            </div>
        </div>
        <div class="col-sm-12 mb-3 mt-3" ><span style="font-size: x-large;" >Reprogramar Empleado</span></div>
        <div class="row" >
            <div class="table-responsive mt-5">
            <table class="table table-striped table-hover" id="rescheduleEmployee" style="width:100%!important">
                <thead>
                </thead>
                <tbody>
                </tbody>
            </table>
            </div>
        </div>
        @else
        <div class="row">
            <div class="alert alert-danger" role="alert">
              El empleado no se encuentra registrado en el sistema o no puede ser mostrado!
            </div> 
        </div>
        @endif
    </div>

<script src="js/datatables.min.js"></script>
<script src="js/dataTables.bootstrap4.min.js"></script>
<script src="js/app/userInfo.js"></script>