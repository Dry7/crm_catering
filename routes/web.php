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

        /** Services */
        Route::resource('services', 'ServiceController');

        /** Products */
        Route::any('/products/import', 'ProductController@import')->name('products.import');
        Route::resource('products', 'ProductController');

        /** Places */
        Route::resource('places', 'PlaceController');
    });

    /** Clients */
    Route::resource('clients', 'ClientController');

    /** Events */
    Route::resource('events', 'EventController');

    /** Calendar */
    Route::get('calendar', 'CalendarController@index')->name('calendar.index');
});

/**
 * Redirect auth routes
 */
Route::any('register',               function () { return redirect()->route('login'); });
Route::any('password/reset',         function () { return redirect()->route('login'); });
Route::any('password/email',         function () { return redirect()->route('login'); });
Route::any('password/reset/{token}', function () { return redirect()->route('login'); });