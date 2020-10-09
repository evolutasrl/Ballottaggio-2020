<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Concerns\TextSearchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Builder;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Support\Facades\DB;

class Voter extends Model
{
    use Searchable;
    use HasFactory;


    protected $guarded = [];
    protected $dates = ['data_nascita'];
    protected $appends = ['list',  'preference'];



    public function votePromises()
    {
        return $this->hasMany('App\Models\VotePromise');
    }

    public function toSearchableArray()
    {
        return $this->only('nome', 'cognome', 'indirizzo_residenza', 'sezione');
    }

    public function getListAttribute($value)
    {
        $promises = $this->votePromises;
        if ($promises->count() ==  0) {
            return null;
        }
        $party = $promises->groupBy('party_id')->max();
        $percentage = $party->count() / $promises->count();

        return [
            "id" => $party->first()->party->id,
            "name" => $party->first()->party->nome,
            "percentage" => $percentage
        ];
    }

    public function prefersCandidate($candidate)
    {
        $totalPromises = DB::table('vote_promises')
            ->where('voter_id', '=', $this->id)
            ->where('candidate_id', '!=', null)
            ->count();

        $promises = DB::table('vote_promises')
                    ->leftJoin('candidates', 'candidate_id', '=', 'candidates.id')
                     ->select(DB::raw('count(*) as count, candidate_id, candidates.nome, candidates.cognome'))
                     ->where('voter_id', '=', $this->id)
                     ->where('candidate_id', '!=', null)
                     //->where('candidate', '=', $candidate)
                     ->groupBy('candidate_id')
                     ->get();

        return $promises->map(function ($promise) use ($totalPromises) {
            $promise->percentage = $promise->count * 100 / $totalPromises;
            return $promise;
        });
    }

    public function getPreferenceAttribute($value)
    {
        $promises = $this->votePromises;

        if ($promises->count() ==  0) {
            return null;
        }

        $candidate = $promises->groupBy('candidate_id')->max();
        $percentage = $candidate->count() / $promises->count();

        return [
            "id" => $candidate->first()->candidate->id??null,
            "name" => ($candidate->first()->candidate)?$candidate->first()->candidate->nome . " " . $candidate->first()->candidate->cognome:"??",
            "percentage" => $percentage
        ];
    }
}
