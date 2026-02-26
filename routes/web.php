<?php

use App\Http\Controllers\ColocationController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('colocations',ColocationController::class);
    Route::get('/colocations/{colocation}/invite', [InvitationController::class, 'create'])
    ->name('invitations.create');
    Route::post('/colocations/{colocation}/invite', [InvitationController::class, 'store'])
    ->name('invitations.store');
    Route::post('/invitation/{token}/accept', [InvitationController::class, 'accept'])
    ->name('invitation.accept');
    Route::post('/invitation/{token}/refuse', [InvitationController::class, 'refuse'])
    ->name('invitation.refuse');
    Route::get('/invitation/{token}', [InvitationController::class, 'page'])
    ->name('invitation.page');
    Route::post('/colocations/{colocation}/leave', [MemberController::class, 'leave'])
    ->name('leave');
    Route::post('/colocations/{colocation}/remove/{user}', [MemberController::class, 'remove'])
    ->name('remove');
});





require __DIR__.'/auth.php';
