<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Voter extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'fullname', 'dob','address', 'postcode', 'boundary_id'
    ];

    public function boundary()
    {
        return $this->belongsTo(Boundary::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vote()
    {
        return $this -> hasMany(Vote::class);
    }

    public function routeNotificationFor($notification)
    {
        // Return the address where the user should receive notifications.
        return $this->email;
    }

    
}
