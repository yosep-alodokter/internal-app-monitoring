<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Modules\Hrd\Models\BusinessUnit;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RoleHasBusinessUnit
 * 
 * @property int $id
 * @property int $roles_id
 * @property int $business_unit_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property BusinessUnit $business_unit
 * @property Role $role
 *
 * @package App\Models
 */
class RoleHasBusinessUnit extends Model
{
	protected $table = 'role_has_business_units';

	protected $casts = [
		'roles_id' => 'int',
		'business_unit_id' => 'int'
	];

	protected $fillable = [
		'roles_id',
		'business_unit_id',
		'email'
	];

	public function business_unit()
	{
		return $this->belongsTo(BusinessUnit::class);
	}

	public function role()
	{
		return $this->belongsTo(Role::class, 'roles_id');
	}
}
