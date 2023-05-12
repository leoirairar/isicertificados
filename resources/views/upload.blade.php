@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="row justify-content-center mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header font-weight-bold">Archivos</div>
                    <div class="card-body">
                        @if (Session::has('message'))
                            <div class="alert alert-success fade show">{{ Session::get('message') }}</div>
                        @endif

                        @if ($files->count() > 0)
                            <table id="files-table" class="table">
                                <thead>
                                    <tr>
                                        <th>Nombre de archivo</th>
                                        <th>Fecha de subida</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($files as $file)
                                        <tr>
                                            <td>{{ $file->name }}</td>
                                            <td>{{ $file->created_at }}</td>
                                            <td>
                                                <a href="{{ route('files.download', ['id' => $file->id]) }}">Descargar</a>
                                                <form action="{{ route('files.delete', ['id' => $file->id]) }}" method="POST" style="display: inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirmDeleteModal{{ $file->id }}">Eliminar</button>
                                                </form>
                                                
                                                <!-- Modal -->
                                <div class="modal fade" id="confirmDeleteModal{{ $file->id }}" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel{{ $file->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="confirmDeleteModalLabel{{ $file->id }}">Confirmar Eliminación</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                ¿Estás seguro de eliminar este archivo?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                <form action="{{ route('files.delete', ['id' => $file->id]) }}" method="POST" style="display: inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                                
                                                
                                                
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>No se han subido archivos.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-4">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Subida de Archivos Planilla</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <form action="{{ route('file.upload') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="file" name="file">
                                            <label class="custom-file-label" for="file">Seleccionar archivo</label>
                                        </div>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit">Subir</button>
                                        </div>
                                    </div>
                                    @error('file')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                               
    
                            </form>
                            </div>
                        </div>

                </div>
            </div>
        </div>
    </div>
    
@endsection

@section('scripts')
    <script src="{{ asset('js/datatables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/app/employee.js') }}"></script>
    <script src="{{ asset('js/app/general.js') }}"></script>
@endsection
