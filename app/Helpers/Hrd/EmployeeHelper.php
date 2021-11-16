<?php

namespace App\Helpers\Hrd;

use DB;
use Error;
use Illuminate\Database\QueryException;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Validation\ValidationException;
use Modules\Hrd\Models\Employee;
use Symfony\Component\ErrorHandler\Error\FatalError;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EmployeeHelper
{

    public function getLastNikEmployee()
    {
        // format NIK contoh : ALO2091
        $textFormat = "ALO";
        $squenceFormat = "0000";
        $defaultFormat = $textFormat . $squenceFormat;
        $dataSend = '';

        // get last data employe with last NIK
        $lastDataEmployee = Employee::orderBy('id', 'DESC')->first();

        if (is_null($lastDataEmployee)) {
            $dataSend = $defaultFormat;
        } else {
            $getLastNumber = substr($lastDataEmployee->nik, 3, 10);
            $squenceNumber = sprintf("%04d", (int) $getLastNumber + 1);
            $dataSend = $textFormat . $squenceNumber;
        }
        
        return $dataSend;
    }
}