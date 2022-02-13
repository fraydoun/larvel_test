<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\auth\LoginRequest;
use App\Models\Admin;
use App\Repositories\AdminRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private $admin;

    public function __construct(AdminRepository $admin)
    {
        $this->admin = $admin;
    }


    public function loginForm(Request $request){

        // $newAdmin = Admin::create([
        //     'name' => 'Fraidoon fetrat',
        //     'username' => 'fetrat',
        //     'password' => bcrypt('123456789'),
        //     'phone_number' => '09907701830',
        //     'email' => 'fetrat_fetrat@gmail.com'
        // ]);
        // dd($newAdmin);
        return view('admin.auth.login');
    }

    public function login(LoginRequest $request){

        $admin = $this->admin->findByUsername($request->get('username'));
        if(! $admin){
            return back()->with('error', 'نام کاربری و رمز عبور مطابقت ندارد');
        }
        if(Auth::guard('admin')->attempt(['username' => $request->get('username'), 'password' => $request->get('password')])){
            return redirect(route('admin.dashboard'));
        }
        
        return back()->with('error','نام کاربری و رمز عبور مطابقت ندارد');

    }


}
