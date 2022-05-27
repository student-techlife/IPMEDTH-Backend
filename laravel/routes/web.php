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

Route::get('/', function () {
    return view('welcome');
});

// Get images from storage
Route::get('/images/{type}/{file}', [ function ($type, $file) {
    $path = storage_path('app/private/images/'.$type.'/'.$file);
    if (file_exists($path)) {
        return response()->file($path, array('Content-Type' => 'image/jpeg'));
    }
    abort(404);
}]);

Route::get('/phpinfo', function () {
    return phpinfo();
});