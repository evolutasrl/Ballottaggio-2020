@extends('layouts.app-side')

@section('content')
    <div class="">

        @if (session('status'))
            <div class="text-sm border border-t-8 rounded text-green-700 border-green-600 bg-green-100 px-3 py-4 mb-4"
                 role="alert">
                {{ session('status') }}
            </div>
        @endif


        <div>

            <div class="bg-gray-900 text-gray-100 p-3 rounded flex items-center my-2">
                <div class="xs font-bold text-gray-600 flex-grow">AVANZAMENTO CARICAMENTO DATI</div>
                <div class="flex items-center">
                    <span class="text-2xl">{{$coverage['votersWithData']}}</span><span class="text-lg">/{{$coverage['totalVoters']}}</span>
                    <span class="text-xl font-bold ml-3">{{number_format($coverage['percentage'],2)}}%</span>
                </div>
            </div>

        </div>


        <div class="mb-3 flex items-center">
            <form action="" class="flex-1">
                <div class="flex items-center">
                    <input name="q" type="text" class="flex-1 rounded text-lg bg-white border border-gray-300 p-3"
                           placeholder="cerca" value="{{request('q','')}}">
                </div>
                <input type="hidden" value="{{request('sort-direction','desc')}}" name="sort-direction">
                <input type="hidden" value="{{request('sort-field','updated_at')}}" name="sort-field">
            </form>
            @if(Auth::user()->is_leader)
            <a href="/crm/voters/create" class="ml-2 cursor-pointer rounded p-4 text-blue-100 bg-blue-900 font-bold uppercase tracking-wide text-xs">Crea</a>
            @endif
        </div>

        <div class="overflow-auto">
        <table class="w-full border-gray-300 shadow rounded ">
            <tr class="bg-blue-900">
                <th class="text-xs text-blue-200 text-left px-2 py-6 ">
                    @include('crm.includes.table._sort', ['field' => 'cognome', 'label' => 'Cognome'])
                </th>
                <th class="text-xs text-blue-200 text-left px-2 py-6 ">
                    @include('crm.includes.table._sort', ['field' => 'nome', 'label' => 'Nome'])
                </th>
                <th class="text-xs text-blue-200 text-left px-2 py-6 ">@include('crm.includes.table._sort', ['field' => 'indirizzo_residenza', 'label' => 'Indirizzo'])</th>
                <th class="text-xs text-blue-200 text-left px-2 py-6 ">@include('crm.includes.table._sort', ['field' => 'sezione', 'label' => 'Sezione'])</th>
                @if(Auth::user()->is_leader)
                <th class="text-xs text-blue-200 text-left px-2 py-6 ">Preferenza</th>
                <th class="text-xs text-blue-200 text-left px-2 py-6 text-right">Percentuale affidabilità</th>
                @endif
                <th class="text-xs text-blue-200 text-left px-2 py-6 ">Lista</th>
                <th class="text-xs text-blue-200 text-left px-2 py-6 text-right">Percentuale affidabilità</th>
                <th class="text-xs text-blue-200 text-left px-2 py-6 text-right">Cancellato</th>
            </tr>

            @foreach($voters as $voter)
                <tr class="bg-white">
                    <td class="p-2"><a href="/crm/voters/{{$voter->id}}">{{$voter->cognome}}</a></td>
                    <td class="p-2"><a href="/crm/voters/{{$voter->id}}">{{$voter->nome}}</a></td>
                    <td class="p-2">{{$voter->indirizzo_residenza}}</td>
                    <td class="p-2">{{$voter->sezione}}</td>

                    @if(Auth::user()->is_leader)
                    <td class="p-2 text-xs w-8">{{$voter->preference["name"]??"-"}}</td>
                    <td class="p-2 text-right text-xs w-8">{{number_format(($voter->preference["percentage"]??1) * 100,2)}}%</td>
                    @endif

                    <td class="p-2 text-xs w-8">{{$voter->list["name"]??"-"}}</td>
                    <td class="p-2 text-right text-xs w-8">{{number_format(($voter->list["percentage"]??1) * 100,2)}}%</td>
                    <td class="p-2 text-right text-xs w-8">@if ($voter->attivo == false)
                        <span>&times;</span>
                    @endif</td>
                </tr>
            @endforeach
        </table>
        </div>
        <div class="w-full flex mt-2 py-2">
            <div class="ml-auto">
                {{ $voters->appends(request()->input())->links() }}
            </div>
        </div>


    </div>
@endsection
