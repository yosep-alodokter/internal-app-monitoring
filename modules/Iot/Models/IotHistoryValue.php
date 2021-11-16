<?php

/**
 * Created by Reliese Model.
 */

namespace Modules\Iot\Models;

use Carbon\Carbon;
use Modules\Iot\Models\IotDevice;
use Illuminate\Database\Eloquent\Model;
use Modules\Iot\Models\IotDeviceDetail;

/**
 * Class IotHistoryValue
 * 
 * @property int $id
 * @property int $iot_device_id
 * @property int $iot_device_detail_id
 * @property string $value
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property IotDeviceDetail $iot_device_detail
 * @property IotDevice $iot_device
 *
 * @package App\Models
 */
class IotHistoryValue extends Model
{
	protected $table = 'iot_history_values';

	protected $casts = [
		'iot_device_id' => 'int',
		'iot_device_detail_id' => 'int'
	];

	protected $fillable = [
		'iot_device_id',
		'iot_device_detail_id',
		'value'
	];

	public function iot_device_detail()
	{
		return $this->belongsTo(IotDeviceDetail::class);
	}

	public function iot_device()
	{
		return $this->belongsTo(IotDevice::class);
	}
}
