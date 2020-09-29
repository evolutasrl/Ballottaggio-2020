<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if(Auth::user()) {
        return redirect("/home");
    } else {
        return redirect("/login");
    }
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::resource('/crm/voters', 'Crm\VoterController')->middleware(['auth']);

Route::get('/crm/votePromise/delete', 'Crm\VotePromiseController@delete')->name('votePromise')->middleware(['auth']);
Route::get('/crm/votePromise', 'Crm\VotePromiseController@store')->name('votePromise')->middleware(['auth']);