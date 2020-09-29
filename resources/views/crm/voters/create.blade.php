@extends('layouts.app-side')

@section('content')
    <div class="w-full">


        <div class="bg-white rounded shadow overflow-hidden">
            <h1 class="mb-4 text-xs font-bold px-3 py-6 bg-blue-900 uppercase text-blue-200"><a href="/crm/customers">Clienti</a> &rarr; Creazione Cliente</h1>
            <form action="/crm/voters" class="p-3" method="post">
                @csrf
              
                <div class="flex flex-wrap -mx-3">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        @include('crm.includes.form._text', ['name'=>'nome', 'label'=>'Nome', 'errors' => $errors
 ,
  'help'=>'' ])
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        @include('crm.includes.form._text', ['name'=>'cognome', 'label'=>'Cognome', 'errors' => $errors
 ,
  'help'=>'' ])
                    </div>
                </div>
                <hr class="my-6">
                <div class="flex flex-wrap -mx-3">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        @include('crm.includes.form._text', ['name'=>'indirizzo_residenza', 'label'=>'Indirizzo Residenza', 'errors' => $errors
 ,
  'help'=>'' ])
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        @include('crm.includes.form._text', ['name'=>'cap_residenza', 'label'=>'Cap Residenza', 'errors' => $errors
 ,
  'help'=>'' ])
                    </div>
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        @include('crm.includes.form._text', ['name'=>'provincia_residenza', 'label'=>'Provincia residenza', 'errors' => $errors
 ,
  'help'=>'' ])
                    </div>
                </div>
                <hr class="my-6">
                <div class="flex flex-wrap -mx-3">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        @include('crm.includes.form._date', ['name'=>'data_nascita', 'label'=>'Data Nascita', 'errors' => $errors
 ,
  'help'=>'' ])
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        @include('crm.includes.form._text', ['name'=>'citta_nascita', 'label'=>'Citta Nascita', 'errors' => $errors
 ,
  'help'=>'' ])
                    </div>
                </div>
                <hr class="my-6">
                <div class="flex flex-wrap -mx-3">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        @include('crm.includes.form._text', ['name'=>'sesso', 'label'=>'Sesso', 'errors' => $errors
 ,
  'help'=>'' ])
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        @include('crm.includes.form._text', ['name'=>'impiego', 'label'=>'Impiego', 'errors' => $errors
 ,
  'help'=>'' ])
                    </div>
                </div>
                <hr class="my-6">
                <div class="flex flex-wrap -mx-3">
                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        @include('crm.includes.form._text', ['name'=>'telefono_fisso', 'label'=>'telefono_fisso', 'errors' => $errors
 ,
  'help'=>'' ])
                    </div>
                    <div class="w-full md:w-1/3 px-3">
                        @include('crm.includes.form._text', ['name'=>'telefono_cellulare', 'label'=>'telefono_cellulare', 'errors' => $errors
 ,
  'help'=>'' ])
                    </div>
                    <div class="w-full md:w-1/3 px-3">
                        @include('crm.includes.form._text', ['name'=>'email', 'label'=>'email', 'errors' => $errors
 ,
  'help'=>'' ])
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 -mb-3 p-3 bg-gray-400">
                    <input type="submit" value="salva"
                           class="ml-auto cursor-pointer rounded p-3 text-blue-100 bg-blue-900 font-bold uppercase tracking-wide text-xs">
                </div>
            </form>
        </div>


    </div>
@endsection
