<?php

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
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

Route::prefix('email')->group(function () {
    // Route::get('/verify', function () {
    //     return view('auth.verify-email');
    // })->name('verification.notice');

    Route::get('/verify/{id}/{token}', function (Request $request) {
        $user = User::find($request->id);

        if($user != null && $user->token == $request->token){
            $user->email_verified_at = Carbon::now();
            $user->save();

            echo "Email berhasil diverifikasi";
        } else {
            echo "Verifikasi gagal";
        }
    })->name('verification.verify');

    // Route::post('/verification-notification', function (Request $request) {
    //     $request->user()->sendEmailVerificationNotification();
    //     return back()->with('status', 'verification-link-sent');
    // })->name('verification.send');
});
