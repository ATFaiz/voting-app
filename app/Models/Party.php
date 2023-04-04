<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Candidate;


class Party extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name','image',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function candidate()
    {
        return $this -> hasMany(Candidate::class);
    }

    public function vote()
    {
        return $this->belongsTo(Vote::class);
    }
}
