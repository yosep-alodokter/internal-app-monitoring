<?php

namespace Modules\Iot\Actions\Api\V1\Device\History\Input;

use Illuminate\Http\Request;

class GetData
{
    public static function handle(Request $request)
    {
        $model = $request->model_type;

        $dataInventory = $model::with('employee')->where('is_active', 'yes')->get();

        $request->request->add([
            'data_inventory' => $dataInventory
        ]);
    }
}