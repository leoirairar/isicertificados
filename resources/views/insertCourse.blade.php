@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="font-weight: bold">Registrar Curso</div>
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <div class="card-body">
                        <form method="POST" action="{{ route('insertCourse') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Nombre del curso') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" maxlength="31"
                                        name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="courseCode"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Título del certificado') }}</label>

                                <div class="col-md-6">
                                    <input id="courseCode" type="text"
                                        class="form-control @error('courseCode') is-invalid @enderror" name="courseCode"
                                        value="{{ old('courseCode') }}" required autocomplete="courseCode" autofocus>
                                    @error('courseCode')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Descripción del curso') }}</label>

                            <div class="col-md-6">
                                <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" required autocomplete="description" autofocus>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div> --}}
                            <div class="form-group row">
                                <label for="prefix"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Prefijo') }}</label>

                                <div class="col-md-6">
                                    <input id="prefix" type="text"
                                        class="form-control @error('prefix') is-invalid @enderror" name="prefix"
                                        value="{{ old('prefix') }}" required autocomplete="prefix" autofocus>
                                    @error('prefix')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="type"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Tipo de curso') }}</label>

                                <div class="col-md-6">
                                    <select class="form-control @error('type') is-invalid @enderror type" id="type"
                                        name="type" required autocomplete="current-type">
                                        <option value="">Selecciona una opción</option>
                                        <option value="1">Curso regular</option>
                                        <option value="2">Curso especial</option>
                                    </select>

                                    @error('type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="documents"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Documentos a subir') }}</label>

                                <div class="col-md-6">
                                    <select multiple
                                        class="form-control selectpicker @error('documents') is-invalid @enderror documents"
                                        id="documents" name="documents[]" required autocomplete="current-documents">
                                        @foreach ($documentsType as $documentType)
                                            <option value="{{ $documentType->id }}">{{ $documentType->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('documents')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="consecutive"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Consecutivo') }}</label>

                                <div class="col-md-6">
                                    <input id="consecutive" type="number"
                                        class="form-control @error('consecutive') is-invalid @enderror" name="consecutive"
                                        value="{{ old('consecutive') }}" required autocomplete="consecutive" autofocus>
                                    @error('consecutive')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="consecutive"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Sede') }}</label>

                                <div class="col-md-6">
                                    <input id="branch" type="Text"
                                        class="form-control @error('branch') is-invalid @enderror" name="branch"
                                        value="{{ old('branch') }}" required autocomplete="branch" autofocus>
                                    @error('branch')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Guardar Curso') }}
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
