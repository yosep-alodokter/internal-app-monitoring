<?php

namespace Modules\Iot\Actions\Api\V1\Device\History\Input;

use Illuminate\Support\Arr;
use League\Fractal\Manager;
use Illuminate\Http\Request;
use League\Fractal\Resource\Collection;

class SetResponse
{
    public static function handle(Request $request)
    {
        $dataInventories = $request->data_inventory;
        $inventoryArray = $dataInventories->toArray();

        $fractal = new Manager();
        $resource = new Collection($inventoryArray, function(array $inventory) {

            $employeeName = (is_null($inventory['employee_id'])) ? '' : " - " . $inventory['employee']['name'];

            return [
                'id' => $inventory['inventory_number'],
                'name' => $inventory['inventory_number'] . $employeeName,
            ];
        });

        $array = $fractal->createData($resource)->toArray();

        $request->request->add([
            'header' => [
                'code' => 200,
                'status' => true,
                'message' => 'data inventory'
            ],
            'data' => $array['data']
        ]);
    }
}