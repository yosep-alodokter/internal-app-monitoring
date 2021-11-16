<?php

namespace App\Helpers;

use App\Models\RoleHasBusinessUnit;
use App\Models\SetConfiguration;
use Error;
use App\Models\UserloginLog;
use Modules\User\Models\User;
use Modules\Hrd\Models\Employee;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Modules\Hrd\Models\BusinessUnit;
use Illuminate\Database\QueryException;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\ErrorHandler\Error\FatalError;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserHelper
{ 
    public function getAuthInfo()
    {
        $userLogin = Auth::user();

        $role = $userLogin->getRoleNames()->first();
        $roleDetail = $userLogin->roles->first();
        $roleHasBu = RoleHasBusinessUnit::with('business_unit')->where('roles_id', $roleDetail->id)->first();

        $employee = Employee::with('business_unit', 'position')->where('id', $userLogin->employee_id)->first();
        $businessUnitData = BusinessUnit::where('id', $userLogin->business_unit_id)->first();

        $data = [
            'employee_id' => (is_null($employee)) ? null : \Crypt::encrypt($employee->id),
            'name' => $userLogin->name,
            'role' => $role,
            'business_unit' => (is_null($employee)) ? (is_null($roleHasBu)) ? null : $roleHasBu->business_unit->name : $businessUnitData->name,
            'business_unit_id' => (is_null($employee)) ? (is_null($roleHasBu)) ? null : $roleHasBu->business_unit_id : $userLogin->business_unit_id,
            'position' => (is_null($employee)) ? '' : $employee->position->name,
            'photo' => (is_null($employee)) ? app('file.helper')->getFileUrl($userLogin->photo, 'user_photo') : app('file.helper')->getFileUrl($employee->photo, 'employee_photo'),
        ];

        return $data;
    }

    public function getAppInfo()
    {
        $appInfo = SetConfiguration::where('config_type', 'app_info')->get()->pluck('value', 'name');

        return $appInfo;
    }

    public function saveProsesLogUser()
    {
        $userLogin = Auth::user();
        $role = $userLogin->getRoleNames()->first();

        // proses save log login user
        UserloginLog::create([
            'name' => $userLogin->name,
            'email' => $userLogin->email,
            'role' => $role,
            'browser' => $_SERVER['HTTP_USER_AGENT'],
            'ip' => $_SERVER['REMOTE_ADDR'],
            'device' => '',
        ]);
    }

    public function roleToGetBusinessUnit()
    {
        $dataList = [];

        // to get role has business unit
        $roleHasBu = RoleHasBusinessUnit::with('role')->get();

        foreach ($roleHasBu as $key => $value) {
            $dataList[$value->role->name] = $value->business_unit_id;
        }

        return $dataList;
    }

    // page : penomoran surat
    public function roleMasterRequestPenomoranSurat() 
    {
        $roles = ['superadmin'];
        $bu_ga = BusinessUnit::where('letter_code', 'GA')->first();

        // to get role has business unit
        $roleHasBu = RoleHasBusinessUnit::with('role')->where('business_unit_id', $bu_ga->id)->get();
        foreach ($roleHasBu as $key => $value) {
            $roles[] = $value->role->name;
        }

        return $roles;
    }

    // page : business unit
    public function roleMasterRequestBusinessUnit() 
    {
        $roles = ['superadmin'];
        $bu_hr = BusinessUnit::where('letter_code', 'HR')->first();

        // to get role has business unit
        $roleHasBu = RoleHasBusinessUnit::with('role')->where('business_unit_id', $bu_hr->id)->get();
        foreach ($roleHasBu as $key => $value) {
            $roles[] = $value->role->name;
        }

        return $roles;
    }

    // page : position
    public function roleMasterRequestPosition() 
    {
        $roles = ['superadmin'];
        $bu_hr = BusinessUnit::where('letter_code', 'HR')->first();

        // to get role has business unit
        $roleHasBu = RoleHasBusinessUnit::with('role')->where('business_unit_id', $bu_hr->id)->get();
        foreach ($roleHasBu as $key => $value) {
            $roles[] = $value->role->name;
        }

        return $roles;
    }

    // page : employee
    public function roleMasterRequestEmployee() {
        $roles = ['superadmin'];
        $bu_hr = BusinessUnit::where('letter_code', 'HR')->first();

        // to get role has business unit
        $roleHasBu = RoleHasBusinessUnit::with('role')->where('business_unit_id', $bu_hr->id)->get();
        foreach ($roleHasBu as $key => $value) {
            $roles[] = $value->role->name;
        }

        return $roles;
    }

    public function roleToPageDashboard() {
        $data = [
            'admin_generalaffair' => 'home_generalaffair',
            'admin_humanresource' => 'home_humanresource',
            'admin_it' => 'home_adminit',
        ];

        return $data;
    }

    public function getRoleWithoutSuperadminAndUser() {

        $tampungRole = [];

        // to get role has business unit
        $roleHasBu = RoleHasBusinessUnit::with('role')->get();
        foreach ($roleHasBu as $key => $value) {
            $tampungRole[] = $value->role->name;
        }

        return $tampungRole;
    }
    
}