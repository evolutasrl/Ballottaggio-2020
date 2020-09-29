<?php

namespace App\Http\Controllers\Crm;

use App\Models\Voter;
use App\Models\Candidate;
use App\Http\Controllers\Controller;
use App\Models\Party;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoterController extends Controller
{
    public function index(Request $request)
    {
        $sortField = $request->get('sort-field', 'updated_at');
        $sortDirection = $request->get('sort-direction', 'desc');
        $q = $request->get('q', '');
        $voters = Voter::stringSearch($q)->orderBy($sortField, $sortDirection)->paginate(15);

        return view('crm.voters.index', compact('voters'));
    }

    public function create()
    {
        return view('crm.voters.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate($this->validator());
        (new Voter($validatedData))->save();

        return redirect('crm/voters');
    }

    public function show(Voter $voter)
    {
        $parties = Party::all();
        return view('crm.voters.show', ['values' => $voter, 'parties' => $parties]);
    }

    public function edit(Voter $voter)
    {
        return view('crm.voters.update', ['values' => $voter]);
    }

    public function update(Request $request, Voter $voter)
    {
   
            $validatedData = $request->validate($this->validator());
            $voter->update($validatedData);

            return redirect('crm/voters');
  
    }

    public function destroy(Voter $voter)
    {
        $voter->delete();
        return redirect('crm/voters');
    }

    private function validator():array
    {
        return [
            'cognome' => 'required',
            'nome' => 'required',
            'citta_residenza' => '',
            'indirizzo_residenza' => 'required',
            'cap_residenza' => '',
            'provincia_residenza' => '',
            'data_nascita' => '',
            'citta_nascita' => '',
            'sesso' => 'required',
            'impiego' => '',
            'telefono_fisso' => '',
            'telefono_cellulare' => '',
            'email' => '',
        ];
    }
}
