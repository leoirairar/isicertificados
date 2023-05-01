@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="font-weight: bold">Registrar Instructor</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('insertInstructor') }}" enctype="multipart/form-data">
                        @csrf 
                        @include('generalUser')
                        {{-- <div class="form-group row">
                            <label for="position" class="col-md-4 col-form-label text-md-right">{{ __('Cargo') }}</label>

                            <div class="col-md-6">
                                <input id="position" type="text" class="form-control @error('position') is-invalid @enderror" name="position" value="{{ old('position') }}" required autocomplete="position" autofocus> @error('position')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span> @enderror
                            </div>
                        </div> --}}
                        <div class="form-group row">
                            <label for="academy_degree" class="col-md-4 col-form-label text-md-right">{{ __('Título academico') }}</label>
    
                            <div class="col-md-6">
                                <select multiple class="form-control selectpicker @error('academy_degree') is-invalid @enderror academy_degree" id="academy_degree" name="academy_degree[]"   autocomplete="current-academy_degree">
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
                            <label for="position" class="col-md-4 col-form-label text-md-right">{{ __('Cargo') }}</label>

                            <div class="col-md-6">
                                <input id="position" type="text" class="form-control @error('position') is-invalid @enderror" name="position" value="{{ old('position') }}" required autocomplete="position" autofocus> 
                                @error('position')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span> @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="licenseNumber" class="col-md-4 col-form-label text-md-right">{{ __('Número de licencia') }}</label>

                            <div class="col-md-6">
                                <input id="licenseNumber" type="text" class="form-control @error('licenseNumber') is-invalid @enderror" name="licenseNumber" value="{{ old('licenseNumber') }}" required autocomplete="licenseNumber" autofocus>
                                @error('licenseNumber')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span> @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="licenseNumber" class="col-md-4 col-form-label text-md-right">{{ __('Firma') }}</label>

                            <div class="col-md-6">
                                <input type="file" class="form-control-file" id="fileSignature" name="fileSignature" id="fileSignature" >
                            </div>
                        </div>
                        {{-- <div class="form-group row mail-pass">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Correo electrónico') }}</label>
                        
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror email" name="email"  value="{{ (isset($user->email )) ? $user->email : old('email')  }}" required autocomplete="current-email"> 
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span> @enderror
                            </div>
                        </div>
                        <div class="form-group row mail-pass">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Contraseña') }}</label>
                        
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror password" name="password" value="{{ (isset($user->password )) ? $user->password : old('password')  }}" required autocomplete="false">  
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span> @enderror
                            </div>
                        </div> --}}
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Guardar Instructor') }}
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
<script src="{{ asset('js/app/instructor.js') }}"></script>
@endsection