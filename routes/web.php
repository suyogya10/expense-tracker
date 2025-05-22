<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExpenseController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/download-apk', function () {
    $filePath = public_path('expense_tracker_v2.apk');

    if (!file_exists($filePath)) {
        abort(404, 'APK not found');
    }

    return response()->download($filePath, 'expense_tracker_v2.apk');
})->name('download.apk');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/profile', 'ProfileController@index')->name('profile');
Route::put('/profile', 'ProfileController@update')->name('profile.update');
Route::post('/user/update-earnings', 'ProfileController@updateEarnings')->name('user.updateEarnings');
Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
Route::delete('/expenses/{id}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');

Route::get('/about', function () {
    return view('about');
})->name('about');