<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MenuTest
 * 
 * @property int $id
 * @property string|null $name
 * @property string|null $icon
 * @property string|null $url
 * @property string|null $description
 * @property int|null $parent_id
 * @property int $level
 * @property int $no_order
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class MenuTest extends Model
{
	protected $table = 'menu_test';

	protected $casts = [
		'parent_id' => 'int',
		'level' => 'int',
		'no_order' => 'int'
	];

	protected $fillable = [
		'name',
		'icon',
		'url',
		'description',
		'parent_id',
		'level',
		'no_order'
	];

	//each category might have one parent
	public function parent() {
		return $this->belongsTo(static::class, 'parent_id');
	}
	
	//each category might have multiple children
	public function children() {
		return $this->hasMany(static::class, 'parent_id')->orderBy('no_order', 'asc');
	}
}
