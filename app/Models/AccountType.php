<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Modules\User\Models\UserAccount;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class AccountType
 * 
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|UserAccount[] $user_accounts
 *
 * @package App\Models
 */
class AccountType extends Model
{
	protected $table = 'account_types';

	protected $fillable = [
		'name'
	];

	public function user_accounts()
	{
		return $this->hasMany(UserAccount::class);
	}
}
