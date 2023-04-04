<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegionalVote extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function voter()
    {
        return $this->belongsTo(Voter::class);
    }

    public function party()
    {
        return $this -> hasMany(Party::class);
    } 
}
