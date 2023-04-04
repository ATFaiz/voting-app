<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Party;
use App\Models\ConstituencyVote;


class Candidate extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'fullname', 'image', 'admin_id', 'constituency', 
        'regional', 'party_id'
    ];

    public function party()
    {
        return $this ->belongsTo(Party::class);
    }

    public function constituencyVote()
    {
        return $this->belongsTo(ConstituencyVote::class);
    }
}
