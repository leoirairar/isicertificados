
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="font-weight: bold">Subir Banner</div>
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <div class="card-body">
                    <form method="POST" action="{{ route('insertBanner') }}" enctype="multipart/form-data">
                        @csrf 
                        
                        <div class="form-group row">
                            <label for="licenseNumber" class="col-md-4 col-form-label text-md-right">{{ __('Seleccionar banner') }}</label>

                            <div class="col-md-6">
                                <input type="file" class="form-control form-control-file target" id="banner" name="banner" id="banner" required>
                            </div>
                        </div>
                        
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Guardar documento') }}
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
