<?php

/**
 * Created by Reliese Model.
 */

namespace Modules\Iot\Models;

use Carbon\Carbon;
use Modules\User\Models\GroupSite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class IotDevice
 * 
 * @property int $id
 * @property string $device_name
 * @property string $device_key
 * @property string $is_active
 * @property int|null $group_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property GroupSite|null $group_site
 * @property Collection|IotDeviceDetail[] $iot_device_details
 *
 * @package App\Models
 */
class IotDevice extends Model
{
	protected $table = 'iot_devices';

	protected $casts = [
		'group_id' => 'int'
	];

	protected $fillable = [
		'device_name',
		'device_key',
		'is_active',
		'group_id'
	];

	public function group_site()
	{
		return $this->belongsTo(GroupSite::class, 'group_id');
	}

	public function iot_device_details()
	{
		return $this->hasMany(IotDeviceDetail::class);
	}
}
