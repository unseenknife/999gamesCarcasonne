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


Route::get('indeling', 'AdministrationController@indeling')->name('indeling');

//Route::get('/', 'PagesController@index')->name('home');


Route::get('/', function () {
    return view('pages.index');
})->name('home');

Route::resource('/gallerij', 'GalleryController');

Route::resource('/ranglijst', 'RankingListsRoundsController');

//we are getting the show function out of the resource
//laravel makes a route for the show function with 1 variable and we want with 2 variables
Route::resource('/tafel', 'TablesController')->except(['show', 'edit', 'update']);
//set route for show function
Route::get('/tafel/{ronde}/{tafel}', 'TablesController@show')->name('tafel.show');

//Samantha
Route::get('/timer', 'RankingListsRoundsController@loadTimer')->name('timer');

Route::get('/tafel/edit/{ronde}/{tafel}', 'TablesController@edit')->name('tafel.edit');

Route::match(array('PUT', 'PATCH'), "/tafel/update/{ronde}/{tafel}", array(
      'uses' => 'TablesController@update',
      'as' => 'tafel.update'
));

Route::resource('/score', 'PointAssignController');
Route::get('/score/round/{round}', 'PointAssignController@round')->name('score.round');
Route::get('/score/round/{round}/{table}', 'PointAssignController@table')->name('score.table');

Route::resource('spelers', 'PlayersController');

Route::get('/admin', 'AdministrationController@admin')->name('admin');
Route::get('/personeel', 'AdministrationController@staff')->name('personeel');

Route::get('/ronde-aanpassen', 'AdministrationController@editRound')->name('round-edit');
Route::get('/users', 'AdministrationController@UserManagement')->name('user-management');
Route::get('/users/{user}', 'AdministrationController@UserManagementEdit')->name('user-edit');
Route::patch('/users-edit/{user}', 'AdministrationController@UpdateUserEdit')->name('user-edit-save');
Route::delete('/users-delete/{user}', 'AdministrationController@DeleteUserEdit')->name('user-edit-delete');

Route::get('/logOutRegister', 'PlayersController@logOutRegister')->name('logOutRegister');
Route::get('/logOutVerify', 'PlayersController@logOutVerify')->name('logOutVerify');


Auth::routes(['verify' => true]);

Route::get('dashboard', function () {
    if (Auth::user() && Auth::user()->roleid == '4')
        return redirect (route('admin'));

    if (Auth::user() && Auth::user()->roleid == '3')
        return redirect (route('personeel'));

    else
        return redirect (route('home'));
})->name('dashboard');

