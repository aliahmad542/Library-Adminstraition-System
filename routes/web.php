<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Hello World, I am here'];
});

require __DIR__.'/auth.php';
