@extends('layouts.app-side')

@section('content')
    <div class="w-full">

        <div class="bg-white p-3 shadow rounded">
            <div class="md:flex items-center bg-blue-900 rounded p-3">
                <div class="text-blue-200 md:mr-4 flex-1 mb-3 md:mb-0">
                    <h3 class="text-lg text-blue-100 mb-1">{{$values->nome}} {{$values->cognome}}</h3>
                    <div class="uppercase text-xs font-bold text-blue-300 mb-1">{{$values->codice_fiscale}}</div>
                    <div
                        class="text-xs font-bold text-blue-200 mb-1">{{$values->citta_nascita}} 
                        
                        @if ($values->data_nascita)
                        {{$values->data_nascita->format('d-m-Y')}}
                        @endif
                        
                    
                    </div>




                </div>
                <div class="text-blue-200 md:mr-4 flex-1 mb-3 md:mb-0">
                    <div class="text-xs font-bold text-blue-300 mb-1">
                        <div class="my-1">{{$values->email}}</div>
                        <div
                            class="text-xs font-bold text-blue-200 mb-1 leading-tight">{{$values->indirizzo_residenza}} {{$values->citta_residenza}}
                            <br>{{$values->cap_residenza}} {{$values->provincia_residenza}}</div>
                    </div>
                </div>
                <div class="text-blue-200 md:mr-4 flex-1 mb-3 md:mb-0">
                    <div class="text-xs font-bold text-blue-300 mb-1">
                        <div class="my-1">{{$values->telefono_fisso}}</div>
                        <div class="my-1">{{$values->telefono_cellulare}}</div>
                        <div class="my-1 text-blue-200">{{$values->email}}</div>
                    </div>
                </div>
            </div>
        </div>

        @if ($values->votePromises()->count() > 0)
        <div class="bg-white p-3 shadow rounded mt-3 flex text-white">
            <div class="bg-gray-900 m-1 rounded p-3 flex items-center">
                <div class="text-xs uppercase mr-2">{{$values->preference["name"]}}</div>
                <div class="text-xl">{{number_format($values->preference["percentage"] * 100,2)}}%</div>
            </div>
            <div class="bg-gray-900 m-1 rounded p-3 flex items-center">
                <div class="text-xs uppercase mr-2">{{$values->list["name"]}}</div>
                <div class="text-xl">{{number_format($values->list["percentage"] * 100,2)}}%</div>
            </div>
        </div>



        
        <div class="bg-white p-3 shadow rounded mt-3">
            <h3 class="p-3 font-bold text-center">Promesse di voto <span class="font-bold text-xs bg-red-600 text-white px-2 py-1 rounded-full">{{$values->votePromises()->count()}}</span></h3>

            <div class="last:border-r-0">
                @foreach ($values->votePromises()->get()->sortByDesc('created_at') as $vp)
                    @if(($vp->user->id === Auth::user()->id) || Auth::user()->is_leader)
                        <div class="m-3 rounded bg-gray-100 shadow p-3 flex items-center">

                            <div class="p-3 text-sm uppercase">{{ $vp->party->nome }}</div>
                            @if($vp->candidate)
                            <div class="p-3 text-sm uppercase font-bold flex-1">{{ $vp->candidate->nome }} {{ $vp->candidate->cognome }}</div>
                            @else
                            <div class="p-3 text-sm uppercase font-bold flex-1">Voto promesso alla lista</div>
                            @endif
                            <div class="p-3 text-sm uppercase text-gray-600">{{$vp->created_at->format('d/m/Y h:i:s')}} <div class="text-xs">Registrato da {{$vp->user->name}}</div> </div>
                            <a href="/crm/votePromise/delete?id={{$vp->id}}">
                                <svg class="w-4 text-red-600 hover:text-red-100 hover:bg-red-600 rounded" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
        </div> 
        @endif
        

        <div class="bg-white p-3 shadow rounded mt-3">
            <h3 class="p-3 font-bold text-center">Dichiara una promessa di voto</h3>
            <div class="md:flex last:border-r-0">
                @foreach ($parties as $party)
                <div class="bg-gray-100 m-2 rounded overflow-hidden shadow flex-grow">
                    <div class="bg-blue-800 p-3 text-xs text-white font-bold text-center">
                        {{$party->nome}}
                    </div>
                    <a href="/crm/votePromise/?party={{$party->id}}&voter={{$values->id}}" class="block text-gray-100 p-1 rounded p-2 m-2 shadow bg-gray-800 uppercase text-xs">
                        Non è chiara la preferenza ma vota la lista
                    </a>
                    @foreach ($party->candidates as $candidato)
                    <a href="/crm/votePromise/?candidate={{$candidato->id}}&voter={{$values->id}}" class="block text-gray-900 p-1 rounded p-2 m-2 shadow bg-white uppercase text-xs">
                            {{$candidato->nome}} {{$candidato->cognome}}
                        </a>
                    @endforeach
                </div>
                @endforeach
            </div>
        </div>

        @if(Auth::user()->is_leader)
                  
        <div class="flex items-center mt-3">
            <div class="md:flex">
            <a href="/crm/voters/{{$values->id}}/edit"
                   class="block cursor-pointer rounded p-3 border-blue-900 text-blue-900 border font-bold uppercase tracking-wide text-xs mr-3">Modifica</a>
                  
                  
                  
                   <form id="delete-form" method="POST" action="/crm/voters/{{$values->id}}" class="inline">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                      <input type="submit" class="block cursor-pointer rounded p-3 border-red-600 text-red-600 border font-bold uppercase tracking-wide text-xs" value="Elimina">
                  </form>
         
            </div>
        </div>

        @endif
    </div>
@endsection
