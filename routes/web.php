<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RelationShipController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JobOfferController;
use App\Http\Controllers\ApplicationsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth', 'role:recruteur'])->group(function(){

});

Route::middleware(['auth', 'role:rechercheur'])->group(function(){
    
});

Route::middleware(['auth', 'permission:offer.create'])->group(function(){

});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::post('/relationships/ajouteami', [RelationShipController::class, 'AjouteAmi'])->name('relationships.ajouteami');
    Route::get('/profile/manage', [ProfileController::class, 'manage'])->name('profile.manage');
    Route::patch('/profile/manage', [ProfileController::class, 'manageUpdate'])->name('profile.manage.update');
    Route::get('/friends', [RelationShipController::class, 'friendsPage'])->name('friends.index');


    Route::post('/relationships/accept', [RelationShipController::class, 'accepter'])->name('relationships.accept');
    Route::post('/relationships/refuse', [RelationShipController::class, 'refuser'])->name('relationships.refuse');
    Route::get('/dashboard', function () {return view('recruteur/dashboard');})->middleware(['auth', 'verified'])->name('dashboard.recruteur');
    Route::get('/dashboard', function () {return view('rechercheur/dashboard');})->middleware(['auth', 'verified'])->name('dashboard.rechercheur');
    Route::get('/search',[UserController::class , 'searchPage'] )->name('users.search');
    Route::get('/users/{id}', [UserController::class , 'detailsPage'])->name('users.show');
    Route::view('/relationships', 'relationships.index')->name('relationships.index');
    Route::view('/notifications', 'notifications.index')->name('notifications.index');
    Route::get('/offers', [JobOfferController::class, 'index'])->name('offers.index');
    Route::post('/offers', [JobOfferController::class, 'store'])->name('offers.store');
    Route::post('/offers/{offer}/close', [JobOfferController::class, 'close'])->name('offers.close');
    Route::get('/offers/{offer}', [JobOfferController::class, 'show'])->name('offers.recruteur.show');

    Route::patch('/applications/{application}/accept', [ApplicationsController::class, 'accept'])
        ->name('applications.accept');
    Route::get('/offers/{offer}/accepted', [JobOfferController::class, 'acceptedApplicants'])
    ->name('offers.accepted');
});

require __DIR__.'/auth.php';
