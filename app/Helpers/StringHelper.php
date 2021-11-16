<?php

namespace App\Helpers;

use Error;
use Illuminate\Database\QueryException;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Validation\ValidationException;
use Modules\GeneralAffair\Models\InvLaptop;
use Modules\GeneralAffair\Models\InvMaintenance;
use Modules\User\Models\GroupSite;
use Symfony\Component\ErrorHandler\Error\FatalError;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class StringHelper
{
    public function setErrorResponseApi($exception)
    {
        if ($exception instanceOf FatalError || $exception instanceof Error) {
            $httpCode = 500;
            $message =  ('production' == config('app.env')) ? 'a fatal error occurred' : $exception->getMessage();
        } else {
            $httpCode = (false == method_exists($exception, 'getStatusCode')) ? 500 : $exception->getStatusCode();
            $message = $exception->getMessage();
        }

        if (true == $exception instanceOf ValidationException) {
            $message = app('string.helper')->getErrorLaravelFirstKey($exception->errors());
            $httpCode = 400;
        }

        if (true == $exception instanceOf NotFoundHttpException) {
        	$message = 'Route not found';
        	$httpCode = 404;
        }

        if (true == $exception instanceOf QueryException) {
        	$message = ('production' == config('app.env')) ? 'Query failed to execute' : $message;
        	$httpCode = 500;
        }

        if (true == $exception instanceOf ClientException) {
        	$message = ('production' == config('app.env')) ? 'Failed fetching request to client' : $message;
        	$httpCode = 500;
        }

        return (200 == $httpCode) ? 
            response()->api(['message' => $message, 'code' => 200, 'status' => true], [], 200) : 
            response()->api(['message' => $message, 'code' => $httpCode, 'status' => false], [], $httpCode);
    }

    /**
     * get single message error, from result validate form request laravel
     *
     * @param  array $arrError list error message
     * @return string if list error message is valid, return single message error
     */
    public function getErrorLaravelFirstKey($arrError)
    {
        if (is_array($arrError)) {
            foreach ($arrError as $key => $value) {
                return $value[0];
            }
        }
        return '';
    }
}