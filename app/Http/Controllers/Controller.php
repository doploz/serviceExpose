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
        $lastRecords = DB::table('metaData')
            ->where('id', $machine) // Filtrar por el número de máquina actual
            ->orderBy('inserDT', 'desc') // Ordenar por la columna 'id' de manera descendente
            ->limit(10)
            ->get(['id', 'cpu', 'memory', 'disk', 'net', 'inserDT']); // Seleccionar las columnas necesarias
    
        // Almacenar los registros en el arreglo $lastRecordsByMachine
        $lastRecordsByMachine["MAQUINA_$machine"] = $lastRecords;
    }
    
    // Devolver el arreglo con los últimos registros de cada máquina
    return response()->json($lastRecordsByMachine);
}
//http://localhost:8000/getAlldata
}