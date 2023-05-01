@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="font-weight: bold">Registrar Empleado</div>
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <div class="card-body">
                    <form method="POST" action="{{ route('insertEmployee') }}">
                        @csrf 
                        @include('generalUser')
                        <div class="form-group row">
                            <label for="birthdate" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de nacimiento') }}</label>
    
                            
                        <div class="col-md-6">
                            <input id="birthdate" type="date" class="form-control @error('birthdate') is-invalid @enderror" name="birthdate" value="{{ old('birthdate') }}"  autocomplete="birthdate" autofocus>
                            
                            @error('birthdate')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span> 
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="academy_degree" class="col-md-4 col-form-label text-md-right">{{ __('Nivel educativo') }}</label>

                        <div class="col-md-6">
                            <select class="form-control @error('academy_degree') is-invalid @enderror academy_degree" id="academy_degree" name="academy_degree"  required autocomplete="current-academy_degree">
                                <option value="">Selecciona una opción</option>
                                @foreach ($academicDegrees as $academy_degree)
                                <option value="{{ $academy_degree->id }}">{{ $academy_degree->name}}</option> 
                                @endforeach
                            </select>
                            @error('academy_degree')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span> @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="company" class="col-md-4 col-form-label text-md-right">{{ __('Empresa') }}</label>

                        <div class="col-md-6">
                            <select class="form-control @error('company') is-invalid @enderror company" id="company" name="company"  required autocomplete="current-company">
                                <option value="">Selecciona una opción</option>
                                @foreach ($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->company_name}}</option> 
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
                            <input id="position" type="text" class="form-control @error('position') is-invalid @enderror" name="position" value="{{ old('position') }}" required autocomplete="position" autofocus> @error('position')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span> @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="emergency_contact_name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre contacto de emergencia') }}</label>
                    
                        <div class="col-md-6">
                            <input id="emergency_contact_name" type="text" class="form-control @error('emergency_contact_name') is-invalid @enderror" name="emergency_contact_name" value="{{ old('emergency_contact_name') }}" required autocomplete="emergency_contact_name" autofocus>
                             @error('emergency_contact_name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                            </span>
                             @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="emergency_phone_number" class="col-md-4 col-form-label text-md-right">{{ __('Número telefónico contacto de emergencia') }}</label>
                    
                        <div class="col-md-6">
                            <input id="emergency_phone_number" type="text" class="form-control @error('emergency_phone_number') is-invalid @enderror" name="emergency_phone_number" value="{{ old('emergency_phone_number')  }}" required autocomplete="emergency_phone_number" autofocus>
                             @error('emergency_phone_number')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span> @enderror
                        </div>
                    </div>
                        {{-- @include('credentials',['update'=> 'N','needPass'=>'N']) --}}
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Guardar Empleado') }}
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
