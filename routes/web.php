<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckUserRole; 

use App\Http\Controllers\UserController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CounselingController;
use App\Http\Controllers\UserCustomFieldController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SentimentAnalyzerController;

Route::redirect('/', '/login');

Route::get('', function () {
    return redirect()->route('profile.edit');
    
});

// Route::get('/dashboard', function () {
//     return view('profile.edit');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // roles
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');

    // Counseling 
    Route::get('/counselings', [CounselingController::class, 'index'])->name('counselings.index');
    Route::get('/counselings/add', [CounselingController::class, 'create'])->name('counselings.create');
    Route::post('/counselings/create', [CounselingController::class, 'store'])->name('counselings.store');
    
    // Show, Edit and Update
    Route::get('/counselings/{id}', [CounselingController::class, 'show'])->name('counselings.show');
    Route::get('/counselings/{id}/edit', [CounselingController::class, 'edit'])->name('counselings.edit');
    Route::put('/counselings/{id}/update', [CounselingController::class, 'update'])->name('counselings.update');
    Route::delete('/counselings/{id}/delete', [CounselingController::class, 'destroy'])->name('counselings.destroy');
    
    // Sentiment Analyzer
    Route::post('/analyze-message', [SentimentAnalyzerController::class, 'analyze']);
    
    // Chat
    Route::post('/counselings/messages', [ChatController::class, 'sendMessage'])->name('messages.store');
    Route::get('/counselings/messages/items', [ChatController::class, 'getMessages'])->name('messages.get');

});

Route::middleware(['auth', CheckUserRole::class])->group(function () {
    Route::resource('/users', UserController::class);
    Route::post('/user/custom-fields', [UserCustomFieldController::class, 'store'])->name('user.custom.fields.store');
    
    // roles
    Route::post('/roles/create', [RoleController::class, 'store'])->name('roles.store');
    Route::put('/roles/{id}/update', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{id}/delete', [RoleController::class, 'destroy'])->name('roles.destroy');
    
    
    
    // Approve and Reject
    Route::post('/counselings/{id}/approve', [CounselingController::class, 'approve'])->name('counselings.approve');
    Route::post('/counselings/{id}/reject', [CounselingController::class, 'reject'])->name('counselings.reject');
    Route::post('/counselings/{id}/start', [CounselingController::class, 'start'])->name('counselings.start');
    Route::post('/counselings/{id}/end', [CounselingController::class, 'end'])->name('counselings.end');
    
    
    
});






require __DIR__.'/auth.php';
