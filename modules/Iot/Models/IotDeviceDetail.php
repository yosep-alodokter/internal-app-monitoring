<?php

/**
 * Created by Reliese Model.
 */

namespace Modules\Iot\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class IotDeviceDetail
 * 
 * @property int $id
 * @property int $iot_device_id
 * @property string $param_type
 * @property string $param_value
 * @property string $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property IotDevice $iot_device
 *
 * @package App\Models
 */
class IotDeviceDetail extends Model
{
	protected $table = 'iot_device_details';

	protected $casts = [
		'iot_device_id' => 'int'
	];

	protected $fillable = [
		'iot_device_id',
		'param_type',
		'param_value',
		'is_active'
	];

	public function iot_device()
	{
		return $this->belongsTo(IotDevice::class);
	}
}
