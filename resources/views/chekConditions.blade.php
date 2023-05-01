

@extends('layouts.app')
@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <div class="card">
            <div class="card-header" style="font-weight: bold">Dashboard</div>
            <div class="card-body">
               <form method="POST" action="{{ route('updateCompanyCondition') }}">
                  @csrf 
                  @method('PUT')
                  <div class="form-group row">
                     <div class="col-md-12">
                        <input class="form-check-input col-md-2 @error('termsConditions') is-invalid @enderror" type="checkbox" value="1" id="termsConditions" name="termsConditions">
                        <label for="termsConditions" class="col-md-7 text-md-right">{{ __('Acepta términios y condiciones ') }}</label> falta link que muestre la info de terminos y condiciones
                        @error('termsConditions')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span> @enderror
                     </div>
                  </div>
                  <div class="form-group row">
                     
                     <div class="col-md-12">
                        <input class="form-check-input col-md-2 @error('habeasData') is-invalid @enderror" type="checkbox" value="1" id="habeasData"  name="habeasData">
                        <label for="habeasData" class="col-md-6 text-md-right">{{ __('Acepta Habeas Data ') }}</label> falta link que muestre la info de habeas data
                        @error('habeasData')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span> @enderror
                     </div>
                  </div>
                  <input id="companyAdmin" class="companyAdmin" name="companyAdmin" type="hidden" value="{{$id}}">
                  <div class="form-group row mb-0">
                        <div class="col-md-8">
                            <button type="submit" class="btn btn-primary" >
                                {{ __('Guardar Condiciones') }}
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

