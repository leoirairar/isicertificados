<div class="form-group row">
    <label for="identification_number" class="col-md-4 col-form-label text-md-right">{{ __('Número de identificación ') }}<label for="" class="" style="color: red;">*</label></label>

    <div class="col-md-6">
        <input required id="identification_number" type="text" class="form-control @error('identification_number') is-invalid @enderror" name="identification_number" value="{{ (isset($user->identification_number )) ? $user->identification_number : old('identification_number') }}"  autocomplete="identification_number" autofocus> 
        @error('identification_number')
        <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span> @enderror
    </div>
</div>
<div class="form-group row">
    <label for="document_type" class="col-md-4 col-form-label text-md-right">{{ __('Tipo de Documento ') }}<label for="" class="" style="color: red;">*</label></label>

    <div class="col-md-6">
        <select required class="form-control @error('document_type') is-invalid @enderror" id="document_type" name="document_type"  autocomplete="current-document_type">
            <option value="">seleccione una opción</option>
            <option value="CC" {{isset($user->document_type) ?($user->document_type=="CC"? 'selected':'') : ''}} >Cedula de ciudadania</option>
            <option value="CE" {{isset($user->document_type) ?($user->document_type=="CE"? 'selected':'') : ''}} >Cedula de extranjeria</option>
            <option value="PE" {{isset($user->document_type) ?($user->document_type=="PE"? 'selected':'') : ''}} >Permiso Especial</option>
        </select>

        @error('document_type')
        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span> @enderror
    </div>
</div>
<div class="form-group row">
    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre ') }} <label for="" class="" style="color: red;">*</label></label>
    
    <div class="col-md-6">
        
        <input required id="name" type="text" class="form-control @error('name') is-invalid @enderror" style="text-transform:uppercase;" name="name" value="{{ (isset($user->name )) ? $user->name : old('name') }}"  autocomplete="name" autofocus> @error('name')
        <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span> @enderror
    </div>
</div>
<div class="form-group row">
    <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Apellidos ') }}<label for="" class="" style="color: red;">*</label></label>

    <div class="col-md-6">
        <input required id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" style="text-transform:uppercase;" name="last_name" value="{{ (isset($user->last_name )) ? $user->last_name : old('last_name')  }}"  autocomplete="last_name" autofocus> @error('last_name')
        <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span> @enderror
    </div>
</div>
<div class="form-group row">
        <label for="phone_number" class="col-md-4 col-form-label text-md-right">{{ __('Número telefonico') }}</label>
    
        <div class="col-md-6">
            <input  id="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ (isset($user->phone_number )) ? $user->phone_number : old('phone_number')  }}"  autocomplete="phone_number" autofocus> @error('phone_number')
            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span> @enderror
        </div>
    </div>