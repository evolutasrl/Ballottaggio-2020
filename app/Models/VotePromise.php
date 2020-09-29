<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VotePromise extends Model
{

    use HasFactory;

    protected $fillable = ["party_id", "candidate_id","voter_id", "user_id"];


    public function party()
    {
        return $this->belongsTo('App\Models\Party');
    }

    public function candidate()
    {
        return $this->belongsTo('App\Models\Candidate');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}

