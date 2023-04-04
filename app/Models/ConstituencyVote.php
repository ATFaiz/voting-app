<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConstituencyVote extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function voter()
    {
        return $this->belongsTo(Voter::class);
    }

    public function candidate()
    {
        return $this->hasMany(Candidate::class);
    }
}
