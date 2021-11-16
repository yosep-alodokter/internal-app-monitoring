<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserloginLog
 * 
 * @property int $id
 * @property string $name
 * @property string|null $email
 * @property string|null $username
 * @property string $role
 * @property string $browser
 * @property string $ip
 * @property string|null $device
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class UserloginLog extends Model
{
	protected $table = 'userlogin_logs';

	protected $fillable = [
		'name',
		'email',
		'username',
		'role',
		'browser',
		'ip',
		'device'
	];
}
