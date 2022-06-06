<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });
//Rotte per l'autenticazione
Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Route::middleware("auth")
    ->namespace("Admin")
    ->name("admin.")
    ->prefix("admin")
    ->group(function () {
        Route::get("/", "HomeController@index")->name("index");
        Route::resource("/posts", "PostController");
    });
//Si utilizza per ultima perché prima deve controllare le rotte precedenti e per ultima questa sotto
//'any?' significa che prende qualsiasi percorso
Route::get('{any?}', function(){
    return view('guest.home');
})->where("any", ".*"); //L'ultimo simbolo tra apici richiama qualsiasi file
