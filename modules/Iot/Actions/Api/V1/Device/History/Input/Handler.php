<?php

namespace Modules\Iot\Actions\Api\V1\Device\History\Input;

use Illuminate\Http\Request;
use Modules\Iot\Models\IotDevice;
use App\Events\RealtimeChartFirst;
use Modules\Iot\Models\IotDeviceDetail;
use Modules\Iot\Models\IotHistoryValue;

class Handler
{
    public function handle(Request $request)
    {
        try {

            $requestAll = $request->all();

            if (!array_key_exists("key", $requestAll)) {
                return response()->api([
                    'code' => 500,
                    'message' => 'membutuhkan data key device'
                ], [], 500);
            } else if (!array_key_exists("id", $requestAll)) {
                return response()->api([
                    'code' => 500,
                    'message' => 'membutuhkan data id device'
                ], [], 500);
            } else {
                $dataCart = [];
                $dataInput = $request->except(['id', 'key']);

                $iotDevice = IotDevice::where('id', $request->id)->where('device_key', $request->key)->where('is_active', 'yes')->first();
                if (is_null($iotDevice)) {
                    return response()->api([
                        'code' => 500,
                        'message' => 'data device tidak ditemukan'
                    ], [], 500);
                }

                foreach ($dataInput as $key => $value) {
                    $detailDeviceIot = IotDeviceDetail::where('is_active', 'yes')->where('iot_device_id', $request->id)->where('param_value', $key)->first();
                    
                    if (!is_null($detailDeviceIot)) {
                        IotHistoryValue::create([
                            'iot_device_id' => $request->id,
                            'iot_device_detail_id' => (int) $detailDeviceIot->id,
                            'value' => $value,
                        ]);
                    }
                }

                $iotDeviceDetail = IotDeviceDetail::where('is_active', 'yes')->where('iot_device_id', $request->id)->get();

                $dataChartPerDevice = self::getDataPerDevice($iotDeviceDetail);
                $dataChartAllDevice = self::getDataAllDevice($iotDeviceDetail);

                $dataCart = [
                    'chartPerDetail' => $dataChartPerDevice,
                    'chartAllDevice' => $dataChartAllDevice,
                ];

                event(new RealtimeChartFirst(json_encode($dataCart)));

                return response()->api([
                    'code' => 200,
                    'message' => 'data berhasil tercatat'
                ], [], 200);
            }
            
        } catch (\Exception $e) {
            return app('string.helper')->setErrorResponseApi($e);
        }
    }

    public function getDataPerDevice($iotDeviceDetail)
    {
        // get value chart every device detail
        $dataValueParent = [];

        foreach ($iotDeviceDetail as $key => $value) {
            $getDataValue = IotHistoryValue::where('iot_device_detail_id', $value->id)->limit(100)->orderBy('created_at', 'DESC')->orderBy('id', 'ASC')->get();

            $dataValueChild = [];
            foreach ($getDataValue as $keys => $values) {  
                $dataValueChild[] = [date_format($values->created_at, "Y-m-d h:i:s A") . ' UTC', (int) $values->value];
            }
            $dataValueParent['chart_line_' . $value->id] = $dataValueChild;
        }

        return $dataValueParent;
    }

    public function getDataAllDevice($iotDeviceDetail)
    {
        // get value chart every device detail
        $dataValueParent = [];

        foreach ($iotDeviceDetail as $key => $value) {
            $getDataValue = IotHistoryValue::where('iot_device_detail_id', $value->id)->limit(100)->orderBy('created_at', 'DESC')->orderBy('id', 'ASC')->get();

            $dataValueChild = [];
            foreach ($getDataValue as $keys => $values) {  
                $dataValueChild[] = [date_format($values->created_at, "Y-m-d h:i:s A") . ' UTC', (int) $values->value];
            }

            $dataValueParent[] = [
                'name' => $value->param_value,
                'data' => $dataValueChild,
            ];
        }

        return $dataValueParent;
    }
}