<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Menu
 * 
 * @property int $id
 * @property string|null $name
 * @property string|null $icon
 * @property string|null $url
 * @property string|null $description
 * @property int $is_parent
 * @property int $no_order
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @package App\Models
 */
class Menu extends Model
{
	protected $table = 'menus';

	protected $casts = [
		'is_parent' => 'int',
		'no_order' => 'int'
	];

	protected $fillable = [
		'name',
		'icon',
		'url',
		'description',
		'is_parent',
		'no_order'
	];
}
