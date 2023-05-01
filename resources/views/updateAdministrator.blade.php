@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="font-weight: bold">Editar administrador ISI</div>
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <div class="card-body">
                    
                    <form method="POST" action="{{ route('updateAdministrator',$admin->id) }}">
                        @csrf 
                        @method('PUT')
                        @include('generalUser',['user'=> $admin->user])
                        <div class="form-group row">
                            <label for="position" class="col-md-4 col-form-label text-md-right">{{ __('Cargo') }}</label>

                            <div class="col-md-6">
                                <input id="position" type="text" class="form-control @error('position') is-invalid @enderror" name="position" value="{{ $admin->position }}" required autocomplete="position" autofocus> @error('position')
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
                                        <option  value="{{ $company->id }}" {{($company->id == $admin->company_id)? 'selected':''}}>{{ $company->company_name}}</option> 
                                        @endforeach
                                    </select>
    
                                    @error('company')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span> @enderror
                                </div>
                            </div>
                        {{-- <div class="form-group row">
                            <label for="role" class="col-md-4 col-form-label text-md-right">{{ __('Tipo de usuario') }}</label>

                            <div class="col-md-6">
                                <select class="form-control @error('role') is-invalid @enderror role" id="role" name="role" readonly required autocomplete="current-role">
                                    <option value="">Selecciona una opción</option>
                                    @if (Auth::user()->role == 'S' || Auth::user()->role == 'M')
                                    <option value="M" selected >Administrador ISI</option>
                                    <option value="I">Trabajador independiente</option>
                                    @endif
                                    <option value="A" >Administrador Empresa</option>
                                    <option value="T">Entrenador</option>
                                    <option value="E">Empleado</option>
                                </select>

                                @error('role')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span> @enderror
                            </div>
                        </div> --}}
                        @include('credentials',['user'=> $admin->user,'update'=> 'Y','needPass'=>'N'])

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Guardar Usuarios') }}
                                </button>
                                <a class="btn btn-danger" href="{{ url('/getAdministrator') }}">Regresar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
