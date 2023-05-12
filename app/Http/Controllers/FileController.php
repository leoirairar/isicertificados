<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Files;
use App\Employee;
use App\user;
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
        $truncatedName = Str::limit($originalName, 30, '');
        $extension = $file->getClientOriginalExtension();
    
        // Generar el nombre del archivo con el código, nombre original y fecha
        $fileName = $code . '-' . $truncatedName . '.'. $extension;
        if ($extension !== 'csv') {
            return redirect()->back()->with('error', "Error: Extensión de archivo inválida. Por favor, asegúrate de seleccionar un archivo CSV.");
        }
        // Guardar el archivo en el almacenamiento
        $file->storeAs('public/files', $fileName);
    
        // Guardar el nombre del archivo, la fecha de subida, el file_id y el código en la base de datos
        $uploadedFile = new Files();
        $uploadedFile->name = $fileName;
        $uploadedFile->employee_id = '16666667';
        $uploadedFile->file_id = $newFileId;
        $uploadedFile->fileroute = 'public/files/' . $fileName; // Guardar la ruta del archivo
        $uploadedFile->save();

        $this->importCSV($uploadedFile->fileroute);
        return redirect()->back()->with('success', 'Archivo subido exitosamente.');
    }
    public function importCSV($filePath)
    {
        $rows = Excel::toCollection([], $filePath)[0]; // Leer el archivo y obtener las filas como una colección
        
    if (count($rows) > 30) {
        return redirect()->back()->with('error', "Error: Extensión de archivo inválida. Por favor, asegúrate de seleccionar un archivo CSV.");
    }
        foreach ($rows as $row) {
            $data_user = [
                'name' => !empty($row[6]) ? $row[6] : 'Sin nombre',
                'last_name' => '',
                'identification_number' => !empty($row[7]) ? $row[7] : 'No se proporcionó',
                'document_type' => 'CC',
                'email' => null,
                'phone_number' => !empty($row[25]) ? $row[25] : 'No se proporcionó',
                'email_verified_at' => null,
                'password' => null,
                'role' => 'E',
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
                'literacy_level' => !empty($row[16]) ? $row[16] : 'No se proporcionó',
                'hemo_classification' => !empty($row[14]) ? $row[14] : 'No se proporcionó',
                'allergies' => !empty($row[18]) ? $row[18] : 'No se proporcionó',
                'recent_medication_use' => null,
                'recent_Injuries' => null,
                'current_diseases' => null,
            ];
            $user = User::create($data_user);

            // Obtener el user_id del usuario creado
            $user_id = $user->id;
            if($user_id!=null){         
                $employee = new Employee;
                $employee->user_id = $user_id;
                $employee->company_id =  $row[1] ?: 0;
                $employee->birthdate =  $row[8] ?: null;
                $employee->academy_degree_id  = $row[10] ?: null;
                $employee->emergency_contact_name  = $row[23] ?: null;
                $employee->emergency_phone_number = $row[24] ?: null;
                $employee->position =  $row[22] ?: null;
                $employee->sector_economico = null;

                $employee->save();

        }
    }
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
    
    public function delete($id)
    {
        try {
            $file = Files::findOrFail($id);
            $file_path = storage_path('app/' . $file->fileroute);
    
            if (file_exists($file_path)) {
                unlink($file_path); // Eliminar el archivo del almacenamiento
            }
    
            $file->delete(); // Eliminar la entrada en la base de datos
    
            return redirect()->back()->with('success', 'Archivo eliminado exitosamente.');
        } catch (\Throwable $th) {
            $error_message = "Ha ocurrido un problema: " . $th->getMessage();
            // Aquí puedes manejar el error o redirigir a una página de error
            return back()->withError($error_message)->withInput();
        }
    }
    

}
