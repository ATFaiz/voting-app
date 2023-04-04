<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\AdminVerifyEmail;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Passwords\CanResetPassword;
use App\Notifications\AdminResetPasswordNotification;

class Admin extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, CanResetPassword;

    // public $password_reset_token;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function party()
    {
        return $this -> hasMany(Party::class);
    }

    public function sendEmailVerificationNotification()
    {
        $verificationUrl = URL::temporarySignedRoute(
            'admin.verification.verify',
            now()->addMinutes(60),
            ['id' => $this->getKey()]
        );

        $this->notify(new AdminVerifyEmail($verificationUrl));
    }


    public function hasVerifiedEmail()
    {
        return !is_null($this->email_verified_at);
    }

   
    public function sendPasswordResetNotification($token)
    {
    $this->notify(new AdminResetPasswordNotification($token));
    }

    



}

