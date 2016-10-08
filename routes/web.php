<?php

Route::get('/', function () {
    if (\Auth::guest()) {
        return redirect('/login');
    } else {
        return view('welcome');
    }
});
