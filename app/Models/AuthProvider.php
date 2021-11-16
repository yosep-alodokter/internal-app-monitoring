<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Modules\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class AuthProvider
 * 
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class AuthProvider extends Model
{
	protected $table = 'auth_providers';

	protected $fillable = [
		'name'
	];

	public function users()
	{
		return $this->belongsToMany(User::class, 'user_auth_providers')
					->withPivot('id', 'unique_user_id_provider')
					->withTimestamps();
	}
}
