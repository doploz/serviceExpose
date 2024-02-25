<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;



    public function getAllUsers()
    {
        // Inicializar un arreglo para almacenar los últimos registros de cada máquina
        $lastRecordsByMachine = [];
    
        // Obtener los números de máquina distintos presentes en la tabla
        $machines = [1, 2, 3, 4]; // Definir el orden deseado de las máquinas
    
        // Iterar sobre cada número de máquina en el orden específico deseado
        foreach ($machines as $machine) {
            // Consultar los últimos 10 registros de la máquina actual
            $lastRecords = DB::table('Metadata')
                ->where('MAQUINA', $machine)
                ->orderBy('inserDT', 'desc')
                ->limit(10)
                ->get();
    
            // Almacenar los registros en el arreglo $lastRecordsByMachine
            $lastRecordsByMachine["MAQUINA_$machine"] = $lastRecords;
        }
    
        // Devolver el arreglo con los últimos registros de cada máquina
        return response()->json($lastRecordsByMachine);
    }
    

//ttp://localhost:8000/getAlldata
}