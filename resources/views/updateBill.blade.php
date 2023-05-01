@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="font-weight: bold">Editar factura</div>
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <div class="card-body">
                    <form method="PUT" action="{{ route('updateBill') }}">
                        @csrf 
                        @method('PUT')
                        <div class="form-group row">
                            <label for="payment" class="col-md-4 col-form-label text-md-right">{{ __('Valor de curso') }}</label>

                            <div class="col-md-6">
                                <input id="payment" type="number" class="form-control @error('payment') is-invalid @enderror" name="payment" value="{{$bill->payment}}" required autocomplete="payment" autofocus> @error('payment')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span> @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="billSerial" class="col-md-4 col-form-label text-md-right">{{ __('Consecutivo de factura') }}</label>

                            <div class="col-md-6">
                                <input id="billSerial" type="text" class="form-control @error('billSerial') is-invalid @enderror" name="billSerial" value="{{$bill->bill_serial}}" required autocomplete="billSerial" autofocus> @error('billSerial')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span> @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="paymentDay" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de pago') }}</label>

                            <div class="col-md-6">
                                <input id="paymentDay" type="date" class="form-control @error('paymentDay') is-invalid @enderror" name="paymentDay" value="{{$bill->payment_day}}" required autocomplete="paymentDay" autofocus> @error('paymentDay')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span> @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                                <label for="enrollmentId" class="col-md-4 col-form-label text-md-right">{{ __('Empleado') }}</label>
    
                                <div class="col-md-6">
                                    <select class="form-control @error('enrollmentId') is-invalid @enderror enrollmentId" id="enrollmentId" name="enrollmentId"  required autocomplete="current-enrollmentId">
                                        <option value="">Selecciona una opción</option>
                                        @foreach ($employeesEnrollment as $employeeEnrollment)
                                        <option value="{{ $employeeEnrollment->id }}" {{($employeeEnrollment->id == $bill->enrollments_id)? 'selected':''}}>{{ $employeeEnrollment->employee->user->name.'-'.$employeeEnrollment->courseProgramming->course->name}}</option> 
                                        @endforeach
                                    </select>
    
                                    @error('enrollmentId')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span> @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="paymentStatus" class="col-md-4 col-form-label text-md-right">{{ __('Estado de pago') }}</label>
                                <div class="col-md-6">
                                    <select class="form-control @error('paymentStatus') is-invalid @enderror paymentStatus" id="paymentStatus" name="paymentStatus"  required autocomplete="current-paymentStatus">
                                        <option value="">Selecciona una opción</option>
                                        <option value="1">Pagó</option>
                                        <option value="0">No Pagó</option>
                                        
                                    </select>
    
                                    @error('paymentStatus')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span> @enderror
                                </div>
                            </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Guardar Factura') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('js/app/bill.js') }}"></script>
@endsection