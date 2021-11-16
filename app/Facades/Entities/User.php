<?php

namespace App\Facades\Entities;

use App\Models\AccountType;
use App\Models\AuthProvider;
use Modules\User\Models\UserAccount;
use Illuminate\Support\Facades\Crypt;
use Modules\Reseller\Models\Reseller;
use Modules\Supplier\Models\Supplier;
use Modules\User\Models\UserAuthProvider;
use Modules\User\Models\User as UserModel;

class User
{
    /**
     * Verify user by email
     *
     * @params string token
     * @return void
     *
     * @throws \DecryptException
     */

    public function verifyUserEmail($token)
    {
        $decrypted = Crypt::decryptString($token);
        
        UserModel::where('email', $decrypted)->update([
            'email_verified_at' => now()
        ]);
    }

    /**
     * create user by auth provider
     *
     * @params string name
     * @params string email
     * @params string role
     * @params string authProviderName
     * @params string uniqueUserAuthProvider
     * @return collection User
     *
     * @throws \QueryException
     */
    public function createByAuthProvider($name, $email, $role, $authProviderName, $uniqueUserAuthProvider)
    {
        $user = UserModel::create([
            'name' => $name,
            'email' => $email,
            'email_verified_at' => now()
        ]);
        
        $user->assignRole($role);

        return $user;
    }
}
