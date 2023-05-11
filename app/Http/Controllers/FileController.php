<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Files;
use Auth;
use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Carbon;

class FileController extends Controller
{
    public function uploadForm()
    {
        $files = Files::where('employee_id', '16666667')->get();

        return view('upload', compact('files'));
    }


    
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);
    
        $file = $request->file('file');
    
        // Generar un código con la fecha y hora actual
        $code = Carbon::now()->format('YmdHis');
    
        // Obtener el último file_id almacenado
        $lastFile = Files::orderBy('file_id', 'desc')->first();
    
        // Obtener el valor de file_id para el nuevo archivo
        $newFileId = $lastFile ? $lastFile->file_id + 1 : 1;
    
        // Separar el nombre original del archivo y la extensión
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
    
        // Generar el nombre del archivo con el código, nombre original y fecha
        $fileName = $code . '-' . $originalName . '-' . Carbon::now()->format('YmdHis') . '.' . $extension;
    
        // Guardar el archivo en el almacenamiento
        $file->storeAs('public/files', $fileName);
    
        // Guardar el nombre del archivo, la fecha de subida, el file_id y el código en la base de datos
        $uploadedFile = new Files();
        $uploadedFile->name = $fileName;
        $uploadedFile->employee_id = '16666667';
        $uploadedFile->file_id = $newFileId;
        $uploadedFile->fileroute = 'public/files/' . $fileName; // Guardar la ruta del archivo
        $uploadedFile->save();
        return redirect()->back()->with('success', 'Archivo subido exitosamente.');
    }
    
    
    public function download($id)
    {
        try {
            $file = Files::findOrFail($id);
            $file_path = storage_path('app/' . $file->fileroute);
    
            if (file_exists($file_path)) {
                return response()->download($file_path);
            } else {
                $error_message = "El archivo no existe.";
                // Aquí puedes manejar el error o redirigir a una página de error
                return back()->withError($error_message)->withInput();
            }
        } catch (\Throwable $th) {
            $error_message = "Ha ocurrido un problema: " . $th->getMessage();
            // Aquí puedes manejar el error o redirigir a una página de error
            return back()->withError($error_message)->withInput();
        }
    }
    
    

}
