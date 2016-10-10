<?php

Route::get('/', function () {
    if (\Auth::guest()) {
        return redirect('/login');
    } else {
        return view('welcome');
    }
});

Route::group(['middleware' => ['auth']], function() {
    Route::group(['middleware' => 'admin'], function() {
        /** Staff */
        Route::resource('staff', 'StaffController');
        Route::post('/staff/save-active', 'StaffController@saveActive')->name('staff.save-active');
    });

    /** Clients */
    Route::resource('clients', 'ClientController');
});