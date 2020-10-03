<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Concerns\TextSearchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Builder;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;

class Voter extends Model
{
    use Searchable;
    use HasFactory;
    use Uuid;


    protected $guarded = [];
    protected $dates = ['data_nascita'];
    protected $appends = ['list',  'preference'];

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

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

        if($promises->count() ==  0) return null;



        $party = $promises->groupBy('party_id')->max();
        $percentage = $party->count() / $promises->count();

        return [
            "id" => $party->first()->party->id,
            "name" => $party->first()->party->nome,
            "percentage" => $percentage
        ];
    }

    public function getPreferenceAttribute($value)
    {
        $promises = $this->votePromises;

        if($promises->count() ==  0) return null;

        $candidate = $promises->groupBy('candidate_id')->max();
        $percentage = $candidate->count() / $promises->count();

        return [
            "id" => $candidate->first()->candidate->id??null,
            "name" => ($candidate->first()->candidate)?$candidate->first()->candidate->nome . " " . $candidate->first()->candidate->cognome:"??",
            "percentage" => $percentage
        ];
    }


}
