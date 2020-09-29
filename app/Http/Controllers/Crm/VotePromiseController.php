<?php

namespace App\Http\Controllers\Crm;

use Illuminate\Http\Request;
use App\Models\VotePromise;
use App\Models\Candidate;
use App\Http\Controllers\Controller;


class VotePromiseController extends Controller
{
    public function store(Request $request)
    {
        $voter = $request->query("voter");
        $candidate = $request->query("candidate");

        $party = $request->query("party");

        if($party) {
            (new VotePromise([
                'party_id' => $party,
                'voter_id' => $voter,
                'user_id' => \Auth::user()->id
            ]))->save(); 
        }else{
            (new VotePromise([
                'party_id' => Candidate::find($candidate)->party_id,
                'voter_id' => $voter,
                'candidate_id' => $candidate,
                'user_id' => \Auth::user()->id
            ]))->save();
        }

        

        return redirect('crm/voters/'. $voter);
    }

    public function delete(Request $request) {
        $promise = VotePromise::find($request->query("id"));
        $voter = $promise->voter_id;
        $promise->delete();
        return redirect('crm/voters/'.$voter);
    }

}
