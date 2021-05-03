<?php

use Illuminate\Support\Facades\Route;

Route::get('/chatter', function () {
    return view('henry-chatter::index');
});
