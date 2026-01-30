<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RelationShipController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/search',[UserController::class , 'searchPage'] )->name('users.search');
Route::get('/users/{id}', [UserController::class , 'detailsPage'])->name('users.show');


Route::view('/relationships', 'relationships.index')->name('relationships.index');
Route::view('/notifications', 'notifications.index')->name('notifications.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/relationships/ajouteami', [RelationShipController::class, 'AjouteAmi'])
        ->name('relationships.ajouteami');
    Route::get('/profile/manage', [ProfileController::class, 'manage'])->name('profile.manage');
    Route::patch('/profile/manage', [ProfileController::class, 'manageUpdate'])->name('profile.manage.update');
    Route::get('/friends', [RelationShipController::class, 'friendsPage'])->name('friends.index');


    Route::post('/relationships/accept', [RelationShipController::class, 'accepter'])->name('relationships.accept');
    Route::post('/relationships/refuse', [RelationShipController::class, 'refuser'])->name('relationships.refuse');
});

require __DIR__.'/auth.php';
