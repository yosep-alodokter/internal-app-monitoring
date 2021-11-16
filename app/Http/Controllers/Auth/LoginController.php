<?php

namespace App\Http\Controllers\Auth;

use DB;
use Auth;
use App\Models\Menu;
use App\Models\SubMenu;
use Illuminate\Http\Request;
use Modules\User\Models\User;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (is_null($user))
            return false;

        $role = $user->getRoleNames()->first();

        if ('admin' == $role || 'superadmin' == $role)
            return Auth::login($user);

        return false;
    }

    public function processLogin(Request $request) 
    {

        $user = User::where('email', $request->email)->first();

        $menu = Menu::orderBy('no_order', 'ASC')->get();
        $submenu= SubMenu::with('menu')->where('status', 1)->orderBy('no_order', 'ASC')->get();

        if(!is_null($user)){
            $query = "
                SELECT b.menu_name FROM 
                role_has_permissions a
                JOIN permissions b ON a.permission_id = b.id
                LEFT JOIN roles c ON a.role_id = c.id
                LEFT JOIN model_has_roles d ON c.id = d.role_id
                LEFT JOIN users e ON e.id = d.model_id
                WHERE e.email = '".$user->email."'
                GROUP BY b.menu_name
                ";

            $email = $user->email;
            $userData = $user;

            $userMenu = DB::select(DB::raw($query));

            if ($userData->is_active == "yes") {
                if (auth()->attempt(['email' => $email, 'password' => $request->password])) {
                    Session::put('sess_menu', $menu);
                    Session::put('sess_submenu', $submenu);
                    Session::put('sess_usermenu', $userMenu);
                    Session::put('sess_user', $user);

                    // jika role adalah user
                    $role = $userData->getRoleNames()->first();

                    if ($userData->is_default_pwd == "yes" && $role == "user") {
                        
                        // save to log login
                        app('user.helper')->saveProsesLogUser();

                        return redirect()->intended('/hrds/employees/' . \Crypt::encrypt($userData->employee_id) . '/by-user')->withInput()->withErrors('Anda masih menggunakan password default, silahkan mengganti password terlebih dahulu');  
                    } else {

                        //save to log login
                        app('user.helper')->saveProsesLogUser();

                        return redirect()->intended('/home');
                    }

                }else{
                    return redirect()->intended('/login')->withInput()->withErrors('Pastikan email dan password benar.');  
                }
            } else {
                return redirect()->intended('/login')->withInput()->withErrors('Akun anda tidak aktif. Silahkan hubungi administrator.');  
            }
        }else{
            return redirect()->intended('/login')->withInput()->withErrors('Pastikan email dan password benar');
        }
    }

    public function logout(Request $request) 
    {
        Session::flush();
        Session::regenerate();
        Auth::logout();
        return redirect('/login');
    }
}
