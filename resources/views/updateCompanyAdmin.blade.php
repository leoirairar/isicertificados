@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="font-weight: bold">Editar administrador de empresa</div>
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <div class="card-body">
                    <form method="POST" action="{{ route('updateCompanyAdministrator',$comAdmin->id) }}">
                        @csrf 
                        @method('PUT')
                        @include('generalUser',['user'=> $comAdmin])
                        
                        <div class="form-group row">
                                <label for="company" class="col-md-4 col-form-label text-md-right">{{ __('Empresa') }}</label>

                                <div class="col-md-6">
                                    <select  class="form-control select-multiple @error('company') is-invalid @enderror company" id="companyAdmin" name="company[]"  required autocomplete="current-company" multiple="multiple">
                                        
                                        <option value="">Selecciona una opción</option>
                                        @foreach ($companies as $company)
                                            @php
                                            $check = false;
                                            @endphp
                                            @if ($comAdmin->companyAdministrator->count()>0)
                                                @foreach ($comAdmin->companyAdministrator as $companiesAdmin)
                                                    @if($companiesAdmin->company_id == $company->id)
                                                        <option selected="selected" value="{{ ($company->id) }}">{{ $company->company_name}}</option>
                                                        @php
                                                        $check = true;
                                                        @endphp
                                                    @endif
                                                @endforeach
                                            @endif
                                                @if ($check == false)
                                                    <option value="{{ $company->id }}" >{{ $company->company_name}}</option>
                                                @endif 
                                        @endforeach
                                    </select>
    
                                    @error('company')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span> @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="position" class="col-md-4 col-form-label text-md-right">{{ __('Cargo') }}</label>
    
                                <div class="col-md-6">
                                    <input id="position" type="text" class="form-control @error('position') is-invalid @enderror" name="position" value="{{ (isset($comAdmin->companyAdministrator[0])?$comAdmin->companyAdministrator[0]->position : '')}}" required autocomplete="position" autofocus> @error('position')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span> @enderror
                                </div>
                            </div>
                        @include('credentials',['user'=> $comAdmin,'update'=> 'Y','needPass'=>'Y'])

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Guardar Usuarios') }}
                                </button>
                                <a class="btn btn-danger" href="{{ url('/getCompanyAdministrator') }}">Regresar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
