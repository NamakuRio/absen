<?php

Route::get('/', 'MainController@index')->name('main')->middleware('auth');
Route::get('/home', function() {
    $role = auth()->user()->roles()->first();

    return redirect($role->login_destination);
})->middleware('auth');

Auth::routes();
