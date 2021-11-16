<?php

/**
 * Created by Reliese Model.
 */

namespace Modules\Iot\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class IotTemperatureHistory
 * 
 * @property int $id
 * @property string $value
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class IotTemperatureHistory extends Model
{
	protected $table = 'iot_temperature_histories';

	protected $fillable = [
		'value'
	];
}
