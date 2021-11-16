<?php

namespace App\Helpers\Iot;

use DB;
use Error;
use Illuminate\Database\QueryException;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\ErrorHandler\Error\FatalError;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DeviceHelper
{
    public function paramTypeList()
    {
        $dataParamType = [
            "sensor" => "sensor",
        ];

        return $dataParamType;
    }
}