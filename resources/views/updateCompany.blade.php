@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="font-weight: bold">Editar empresa</div>
                @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <div class="card-body">
                    <form method="POST" action="{{ route('updateCompany',$company->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="nit" class="col-md-4 col-form-label text-md-right">{{ __('Nit') }}</label>

                            <div class="col-md-6">
                                <input id="nit" type="text" class="form-control @error('nit') is-invalid @enderror" name="nit" value="{{$company->nit}}" required autocomplete="nit" autofocus>

                                @error('nit')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="company_name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre de la empresa') }}</label>

                            <div class="col-md-6">
                                <input id="company_name" type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name" value="{{ $company->company_name }}" required autocomplete="company_name" autofocus>

                                @error('company_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Dirección') }}</label>

                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{  $company->address }}" required autocomplete="address" autofocus>

                                @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="phone_number" class="col-md-4 col-form-label text-md-right">{{ __('Número de teléfono') }}</label>

                            <div class="col-md-6">
                                <input id="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ $company->phone_number }}" required autocomplete="phone_number" autofocus>

                                @error('phone_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="website" class="col-md-4 col-form-label text-md-right">{{ __('Página web') }}</label>


                            <div class="col-md-6">
                                <input id="website" type="text" class="form-control @error('website') is-invalid @enderror" name="website" value="{{ $company->website }}" autocomplete="website" autofocus>

                                @error('website')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="creation_date" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de vinculación') }}</label>


                            <div class="col-md-6">
                                <input id="creation_date" type="date" class="form-control @error('creation_date') is-invalid @enderror" name="creation_date" value="{{ $company->creation_date }}" autocomplete="creation_date" autofocus>

                                @error('creation_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="emailCompany" class="col-md-4 col-form-label text-md-right">{{ __('Correo electrónico') }}</label>

                            <div class="col-md-6">
                                <input id="emailCompany" type="text" class="form-control @error('emailCompany') is-invalid @enderror" name="emailCompany" value="{{ $company->email }}" required autocomplete="emailCompany" autofocus>

                                @error('emailCompany')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="company" class="col-md-4 col-form-label text-md-right">{{ __('ARL ') }} <label for="" class="" style="color: red;">*</label></label>
                            <div class="col-md-6">
                                <input id="arl" type="text" style="text-transform:uppercase;" class="form-control @error('arl') is-invalid @enderror" name="arl" value="{{ $company->arl }}" autocomplete="arl" autofocus required>
                                @error('arl')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="legal_agent" class="col-md-4 col-form-label text-md-right">{{ __('Representante legal') }}</label>

                            <div class="col-md-6">
                                <input id="legal_agent" type="text" class="form-control @error('legal_agent') is-invalid @enderror" name="legal_agent" value="{{ $company->legal_agent }}" required autocomplete="legal_agent" autofocus>

                                @error('legal_agent')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="sector_economico" class="col-md-4 col-form-label text-md-right">{{ __('Sector económico') }}</label>
                            <div class="col-md-6">
                                <select class="form-control @error('sector_economico') is-invalid @enderror sector_economico" id="sector_economico" name="sector_economico" required autocomplete="current-sector_economico">
                                    <option disabled value="" {{$company->sector_economico== null ? 'selected':''}}>Selecciona una opción</option>
                                    <option value="Sector agropecuario" {{$company->sector_economico=="Sector agropecuario"? 'selected':''}}>Sector agropecuario</option>
                                    <option value="Sector comercio y servicios" {{$company->sector_economico=="Sector comercio y servicios"? 'selected':''}}>Sector comercio y servicios</option>
                                    <option value="Sector industrial" {{$company->sector_economico=="Sector industrial"? 'selected':''}} >Sector industrial</option>
                                    <option value="Sector de transporte" {{$company->sector_economico=="Sector de transporte"? 'selected':''}}>Sector de transporte</option>
                                    <option value="Sector de comercio" {{$company->sector_economico=="Sector de comercio"? 'selected':''}}>Sector de comercio</option>
                                    <option value="Sector financiero" {{$company->sector_economico=="Sector financiero"? 'selected':''}}>Sector financiero</option>
                                    <option value="Sector de la construcción" {{$company->sector_economico=="Sector de la construcción"? 'selected':''}}>Sector de la construcción</option>
                                    <option value="Sector minero y energético" {{$company->sector_economico=="Sector minero y energético"? 'selected':''}}>Sector minero y energético</option>
                                    <option value="Sector de telecomunicaciones" {{$company->sector_economico=="Sector de telecomunicaciones"? 'selected':''}}>Sector de telecomunicaciones</option>
                                    <option value="Sector de educación" {{$company->sector_economico=="Sector de educación"? 'selected':''}}>Sector de educación</option>
                                </select>
                                @error('sector_economico')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="accounting_contact_name" class="col-md-4 col-form-label text-md-right">{{ __('Nomnbre contacto de contabilidad') }}</label>

                            <div class="col-md-6">
                                <input id="accounting_contact_name" type="text" class="form-control @error('accounting_contact_name') is-invalid @enderror" name="accounting_contact_name" value="{{ $company->accounting_contact_name }}" required autocomplete="accounting_contact_name" autofocus>

                                @error('accounting_contact_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="accounting_contact_email" class="col-md-4 col-form-label text-md-right">{{ __('Correo electrónico de contabilidad') }}</label>

                            <div class="col-md-6">
                                <input id="accounting_contact_email" type="text" class="form-control @error('accounting_contact_email') is-invalid @enderror" name="accounting_contact_email" value="{{ $company->accounting_contact_email }}" required autocomplete="accounting_contact_email" autofocus>

                                @error('accounting_contact_email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="accounting_contact_phone" class="col-md-4 col-form-label text-md-right">{{ __('Número telefónico de contabilidad') }}</label>

                            <div class="col-md-6">
                                <input id="accounting_contact_phone" type="text" class="form-control @error('accounting_contact_phone') is-invalid @enderror" name="accounting_contact_phone" value="{{ $company->accounting_contact_phone }}" required autocomplete="accounting_contact_phone" autofocus>

                                @error('accounting_contact_phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        {{-- <div class="form-group row">
                            <label for="humanresources_contact_name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre contacto de quien programa' ) }}</label>
                        <div class="col-md-6">
                            <input id="humanresources_contact_name" type="text" class="form-control @error('humanresources_contact_name') is-invalid @enderror" name="humanresources_contact_name" value="{{ $company->humanresources_contact_name }}" required autocomplete="humanresources_contact_name" autofocus>
                            @error('humanresources_contact_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                </div>
                <div class="form-group row">
                    <label for="humanresources_contact_email" class="col-md-4 col-form-label text-md-right">{{ __('Correo electrónico de quien programa') }}</label>
                    <div class="col-md-6">
                        <input id="humanresources_contact_email" type="text" class="form-control @error('humanresources_contact_email') is-invalid @enderror" name="humanresources_contact_email" value="{{$company->humanresources_contact_email }}" required autocomplete="humanresources_contact_email" autofocus>
                        @error('humanresources_contact_email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="humanresources_contact_phone" class="col-md-4 col-form-label text-md-right">{{ __('Número telefónico de quien programa') }}</label>
                    <div class="col-md-6">
                        <input id="humanresources_contact_phone" type="text" class="form-control @error('humanresources_contact_phone') is-invalid @enderror" name="humanresources_contact_phone" value="{{ $company->humanresources_contact_phone }}" required autocomplete="humanresources_contact_phone" autofocus>
                        @error('humanresources_contact_phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div> --}}
                <div class="form-group row">
                    <label for="country_id" class="col-md-4 col-form-label text-md-right">{{ __('Pais') }}</label>
                    <div class="col-md-6">
                        <select class="form-control @error('country_id') is-invalid @enderror country_id" id="country_id" name="country_id" required autocomplete="current-country_id">
                            <option value="">Selecciona una opción</option>
                            @foreach($countries as $count)
                            <option value="{{ $count['id'] }}" {{($count['id'] == $company->country_id)? 'selected':''}}>{{ $count['name']}}</option>
                            @endforeach
                        </select>

                        @error('country_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span> @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="town_id" class="col-md-4 col-form-label text-md-right">{{ __('Departamento') }}</label>
                    <div class="col-md-6">
                        <select class="form-control @error('town_id') is-invalid @enderror town_id" id="town_id" name="town_id" required autocomplete="current-town_id">
                            <option value="">Selecciona una opción</option>
                            @foreach($states as $states)
                            <option value="{{ $states->id }}" {{($states->id == $company->town_id)? 'selected':''}}>{{ $states->name}}</option>
                            @endforeach
                        </select>

                        @error('town_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span> @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="status" class="col-md-4 col-form-label text-md-right">{{ __('Estado') }}</label>
                    <div class="col-md-6">
                        <select class="form-control @error('status') is-invalid @enderror status" id="status" name="status" required autocomplete="current-status">
                            <option value="">Selecciona una opción</option>
                            <option value="1" {{old('revalidable',$company->status)=="1"? 'selected':''}}>Activo</option>
                            <option value="0" {{old('revalidable',$company->status)=="0"? 'selected':''}}>inactivo</option>

                        </select>

                        @error('status')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span> @enderror
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Guardar Empresa') }}
                        </button>
                        <a class="btn btn-danger" href="{{ url('/getCompanies') }}">Regresar</a>
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
<script src="{{ asset('js/app/general.js') }}"></script>
@endsection