<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MpSetting
 * 
 * @property int $id
 * @property string $key
 * @property string $value
 * @property string $env
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class MpSetting extends Model
{
	protected $table = 'mp_settings';

	protected $fillable = [
		'key',
		'value',
		'env',
		'description'
	];
}
