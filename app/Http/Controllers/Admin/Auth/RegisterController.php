<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\RegistersAdmins;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Admin;
use App\Notifications\AdminVerifyEmail;


class RegisterController extends Controller
{
    use RegistersAdmins;

    protected $redirectTo = '/admin/dashboard';

    public function __construct()
    {
        $this->middleware('guest:admin');
        
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    protected function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $admin = $this->create($request->all());

        // Generate a verification token and save it to the database
        $admin->verification_token = Str::random(40);
        $admin->save();

        $url = route('admin.verification.verify', [
            'id' => $admin->getKey(),
            'hash' => $admin->verification_token
        ]);

        $this->guard()->login($admin);
        
        if ($admin->email_verified_at === null) {
            $admin->notify(new adminVerifyEmail($url));
            return redirect()->route('admin.verification.notice');
        }

        return redirect($this->redirectTo);
    }

    protected function create(array $data)
    {
        return Admin::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
