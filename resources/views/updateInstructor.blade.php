@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="font-weight: bold">Editar Instructor</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('updateInstructor',$instructor->id) }}" enctype="multipart/form-data">
                        @csrf 
                        @method('PUT')
                        @include('generalUser',['user'=> $instructor->user])
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
                                    @foreach ($academicDegrees as $academyDegree)
                                        @php
                                        $check = false;
                                        @endphp
                                        @if ($instructor->academicDegrees->count()>0)
                                            @foreach ($instructor->academicDegrees as $instructorAcademyDregrees)
                                                @if($instructorAcademyDregrees->id == $academyDegree->id)
                                                    <option selected="selected" value="{{ ($academyDegree->id) }}">{{ $academyDegree->name}}</option>
                                                    @php
                                                    $check = true;
                                                    @endphp
                                                @endif
                                            @endforeach
                                        @endif
                                            @if ($check == false)
                                                <option value="{{ $academyDegree->id }}" >{{ $academyDegree->name}}</option>
                                            @endif 
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
                                <input id="position" type="text" class="form-control @error('position') is-invalid @enderror" name="position" value="{{ $instructor->position }}" required autocomplete="position" autofocus> 
                                @error('position')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span> @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="licenseNumber" class="col-md-4 col-form-label text-md-right">{{ __('Número de licencia') }}</label>

                            <div class="col-md-6">
                                <input id="licenseNumber" type="text" class="form-control @error('licenseNumber') is-invalid @enderror" name="licenseNumber" value="{{$instructor->license_number }}" required autocomplete="licenseNumber" autofocus>
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
                                @if ($instructor->sign_name != null)
                                    <a href="{{ route('downloadSign',$instructor->sign_name) }}" class="badge badge-primary" >Ver firma</a>
                                @endif
                                
                            </div>
                        </div>
                        {{-- <div class="form-group row mail-pass">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Correo electrónico') }}</label>
                        
                            <div class="col-md-6">
                                <input id="email" type="email" readonly class="form-control @error('email') is-invalid @enderror email" name="email"  value="{{ (isset($instructor->user->email )) ? $instructor->user->email : old('email')  }}" required autocomplete="current-email"> 
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span> @enderror
                            </div>
                        </div> --}}
                        {{-- @include('credentials',['update'=> 'N','needPass'=>'N']) --}}
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Guardar Instructor') }}
                                </button>
                                <a class="btn btn-danger" href="{{ url('/getInstructor') }}">Regresar</a>
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