<?php

namespace App\Http\Controllers;

use DB;
use File;
use Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Modules\Hrd\Models\Employee;
use Modules\Iot\Models\IotDevice;
use Illuminate\Support\Facades\Auth;
use Modules\Iot\Models\IotDeviceDetail;
use Modules\Iot\Models\IotHistoryValue;

class MonitoringController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $iotDevice = IotDevice::with('iot_device_details')->where('is_active', 'yes')->get();
        $dataIotDevice = $iotDevice->pluck('device_name', 'id');

        return view('welcome', compact('dataIotDevice'));
    }

    public function detail($id)
    {
        $iotDeviceDetail = IotDeviceDetail::where('is_active', 'yes')->where('iot_device_id', $id)->get();
        $dataIotDeviceDetail = $iotDeviceDetail->pluck('param_value', 'id');

        // get value chart every device detail
        $dataValueParent = [];

        foreach ($iotDeviceDetail as $key => $value) {
            $getDataValue = IotHistoryValue::where('iot_device_detail_id', $value->id)->limit(10)->orderBy('created_at', 'DESC')->orderBy('id', 'ASC')->get();

            $dataValueChild = [];
            foreach ($getDataValue as $keys => $values) {  
                $dataValueChild[] = [date_format($values->created_at, "Y-m-d h:i:s A") . ' UTC', (int) $values->value];
            }
            $dataValueParent[$value->param_value] = $dataValueChild;
        }

        return response()->api([
            'code' => 200,
            'message' => 'Berhasil detail data'
        ], [
            'detailDevice' => $dataIotDeviceDetail,
            'chartValueDevice' => $dataValueParent,
        ], 200);
    }
}
