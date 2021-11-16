<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SetConfiguration
 * 
 * @property int $id
 * @property string $name
 * @property string $config_type
 * @property string $value
 * @property string $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class SetConfiguration extends Model
{
	protected $table = 'set_configurations';

	protected $fillable = [
		'name',
		'config_type',
		'value',
		'is_active'
	];
}
