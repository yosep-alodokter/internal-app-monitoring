<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Submenu
 * 
 * @property int $id
 * @property int $menu_id
 * @property string|null $name
 * @property string|null $icon
 * @property string|null $url
 * @property string|null $description
 * @property int $status
 * @property int $no_order
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @package App\Models
 */
class SubMenu extends Model
{
	protected $table = 'submenus';

	protected $casts = [
		'menu_id' => 'int',
		'status' => 'int',
		'no_order' => 'int'
	];

	protected $fillable = [
		'menu_id',
		'name',
		'icon',
		'url',
		'description',
		'status',
		'no_order'
	];

	public function menu()
	{	
	    return $this->belongsTo("App\Models\Menu", "menu_id");
	}
}
