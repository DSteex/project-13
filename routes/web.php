<?php

use App\Http\Controllers\LinkController;
use App\Models\Link;
use App\Models\LinkClick;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/{code}', [LinkController::class, 'redirect'])->name('links.redirect');