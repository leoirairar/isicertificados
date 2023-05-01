@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="font-weight: bold">Registrar administrador ISI</div>
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <div class="card-body">
                    <form method="POST" action="{{ route('insertAdministrator') }}">
                        @csrf 
                        @include('generalUser')
                        <div class="form-group row">
                            <label for="position" class="col-md-4 col-form-label text-md-right">{{ __('Cargo') }}</label>

                            <div class="col-md-6">
                                <input id="position" type="text" class="form-control @error('position') is-invalid @enderror" name="position" value="{{ old('position') }}" required autocomplete="position" autofocus> @error('position')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span> @enderror
                            </div>
                        </div>
                        @include('credentials',['update'=> 'N','needPass'=>'Y'])

                        <div class="form-group row mb-0">
                            <div id="btnSave" class="col-md-8 offset-md-4">
                                <button  type="submit" class="btn btn-primary">
                                    {{ __('Guardar Usuarios') }}
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
