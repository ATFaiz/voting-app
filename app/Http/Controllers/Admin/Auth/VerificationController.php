<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use App\Notifications\AdminVerifyEmail;


class VerificationController extends Controller
{
    use VerifiesEmails;

    protected $redirectTo = '/admin/dashboard';

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('signed:admin')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
        
    }

public function show()
{
    return view('admin.auth.verification');
}

public function send(Request $request)
{
    $admin = $request->user('admin');

    if ($admin->hasVerifiedEmail()) {
        return redirect('/admin/dashboard')->with('success', 'Your email is already verified.');
    }

    $url = route('admin.verification.verify', [
        'id' => $admin->getKey(),
        'hash' => $admin->verification_token
    ]);

    $admin->notify(new AdminVerifyEmail($url));

    return back()->with('success', 'Verification email sent!');
}

public function resend(Request $request)
{
    $admin = $request->user('admin');
    $verificationUrl = URL::temporarySignedRoute(
        'admin.verification.verify',
        now()->addMinutes(60),
        [
            'id' => $admin->getKey(),
            'hash' => sha1($admin->getEmailForVerification())
        ]
    );
    $admin->notify(new AdminVerifyEmail($verificationUrl));
    return back()->with('success', 'Verification email sent!');
}


public function verify(EmailVerificationRequest $request)
{
    $request->fulfill();

    event(new Verified($request->user('admin')));

    return redirect('/admin/dashboard')->with('success', 'Email verified!');
}


}
