@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="font-weight: bold">Editar Curso</div>
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <div class="card-body">
                    <form method="POST" action="{{ route('updateCourse',$course->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre del curso') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $course->name }}" required autocomplete="name" autofocus>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span> @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="courseCode" class="col-md-4 col-form-label text-md-right">{{ __('Título') }}</label>

                            <div class="col-md-6">
                                <input id="courseCode" type="text" class="form-control @error('courseCode') is-invalid @enderror" name="courseCode" value="{{ $course->course_code }}" required autocomplete="courseCode" autofocus>
                                {{-- <select class="form-control @error('courseCode') is-invalid @enderror courseCode" id="courseCode" name="courseCode"  required autocomplete="current-courseCode">
                                        <option value="">Selecciona una opción</option>
                                        <option {{($course->course_code=="Nivel avanzado")? 'selected':''}} value="Nivel avanzado"  >Nivel avanzado</option>
                                        <option {{($course->course_code=="Reentrenamiento Nivel Avanzado")? 'selected':''}}  value="Reentrenamiento Nivel Avanzado">Reentrenamiento Nivel Avanzado</option>
                                    </select> --}}
                                @error('courseCode')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span> @enderror
                            </div>
                        </div>

                        {{-- <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Descripción del curso') }}</label>

                            <div class="col-md-6">
                                <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ $course->description }}" required autocomplete="description" autofocus>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span> @enderror
                            </div>
                        </div> --}}
                        <div class="form-group row">
                                <label for="prefix" class="col-md-4 col-form-label text-md-right">{{ __('Prefijo') }}</label>

                                <div class="col-md-6">
                                    <input id="prefix" type="text" class="form-control @error('prefix') is-invalid @enderror" name="prefix" value="{{ $course->prefix }}" required autocomplete="prefix" autofocus>
                                    @error('prefix')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                        <div class="form-group row">
                            <label for="type" class="col-md-4 col-form-label text-md-right">{{ __('Tipo de curso') }}</label>

                            <div class="col-md-6">
                                <select class="form-control @error('type') is-invalid @enderror type" id="type" name="type"  required autocomplete="current-type">
                                    <option value="">Selecciona una opción</option>
                                    <option {{old('type',$course->type)=="1"? 'selected':''}} value="1"  >Curso regular</option>
                                    <option {{old('type',$course->type)=="2"? 'selected':''}} value="2">Curso especial</option>

                                </select>

                                @error('type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span> @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                                <label for="documents" class="col-md-4 col-form-label text-md-right">{{ __('Documentos a subir') }}</label>

                             <div class="col-md-6">
                                 <select multiple class="form-control selectpicker @error('documents') is-invalid @enderror documents" id="documents" name="documents[]"  required autocomplete="current-documents" style="border:1px solid #ccc">

                                        <option value="">Selecciona una opción</option>
                                        @foreach ($documentsType as $documentType)
                                            @php
                                            $check = false;
                                            @endphp
                                            @if ($course->documentsType->count()>0)
                                                @foreach ($course->documentsType as $courseDocumentsType)
                                                    @if($courseDocumentsType->id == $documentType->id)
                                                        <option selected="selected" value="{{ ($documentType->id) }}">{{ $documentType->name}}</option>
                                                        @php
                                                        $check = true;
                                                        @endphp
                                                    @endif
                                                @endforeach
                                            @endif
                                                @if ($check == false)
                                                    <option value="{{ $documentType->id }}" >{{ $documentType->name}}</option>
                                                @endif
                                        @endforeach
                                 </select>

                                 @error('documents')
                                 <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                 </span> @enderror
                             </div>
                         </div>

                        <div class="form-group row">
                            <label for="status" class="col-md-4 col-form-label text-md-right">{{ __('Estado') }}</label>

                            <div class="col-md-6">
                                <select class="form-control @error('status') is-invalid @enderror status" id="status" name="status" required  autocomplete="current-status">
                                    <option value="">Selecciona una opción</option>
                                    <option {{old('status',$course->status)=="1"? 'selected':''}} value="1">Activo</option>
                                    <option {{old('status',$course->status)=="0"? 'selected':''}} value="0">Inactivo</option>
                                </select>

                                @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span> @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="consecutive" class="col-md-4 col-form-label text-md-right">{{ __('Consecutivo') }}</label>

                            <div class="col-md-6">
                                <input id="consecutive" type="text" class="form-control @error('consecutive') is-invalid @enderror" name="consecutive" value="{{ isset($course->consecutive->id)?$course->consecutive->id:0 }}" required autocomplete="consecutive" autofocus>
                                @error('consecutive')
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
                                <a class="btn btn-danger" href="{{ url('/getCourses') }}">Regresar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
