<?php

use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return 'Test berhasil!';
});

Route::get('/test-db', function () {
    try {
        $users = DB::table('users')->count();
        return "Database OK. Users: $users";
    } catch (Exception $e) {
        return "Database Error: " . $e->getMessage();
    }
});