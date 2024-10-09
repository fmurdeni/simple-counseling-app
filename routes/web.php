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

Route::get('/admin', function () {
    return redirect()->route('dashboard');
    
});

Route::get('/admin/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/admin/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/admin/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/admin/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // roles
    Route::get('/admin/roles', [RoleController::class, 'index'])->name('roles.index');

    // Counseling 
    Route::get('/admin/counselings', [CounselingController::class, 'index'])->name('counselings.index');
    Route::get('/admin/counselings/add', [CounselingController::class, 'create'])->name('counselings.create');
    Route::post('/admin/counselings/create', [CounselingController::class, 'store'])->name('counselings.store');
    
    // Show, Edit and Update
    Route::get('/admin/counselings/{id}', [CounselingController::class, 'show'])->name('counselings.show');
    Route::get('/admin/counselings/{id}/edit', [CounselingController::class, 'edit'])->name('counselings.edit');
    Route::put('/admin/counselings/{id}/update', [CounselingController::class, 'update'])->name('counselings.update');
    Route::delete('/admin/counselings/{id}/delete', [CounselingController::class, 'destroy'])->name('counselings.destroy');
    
    // Sentiment Analyzer
    Route::post('/admin/analyze-message', [SentimentAnalyzerController::class, 'analyze']);
    
    // Chat
    Route::post('/admin/counselings/messages', [ChatController::class, 'sendMessage'])->name('messages.store');
    Route::get('/admin/counselings/messages/items', [ChatController::class, 'getMessages'])->name('messages.get');

});

Route::middleware(['auth', CheckUserRole::class])->group(function () {
    Route::resource('/admin/users', UserController::class);
    Route::post('/admin/user/custom-fields', [UserCustomFieldController::class, 'store'])->name('user.custom.fields.store');
    
    // roles
    Route::post('/admin/roles/create', [RoleController::class, 'store'])->name('roles.store');
    Route::put('/admin/roles/{id}/update', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/admin/roles/{id}/delete', [RoleController::class, 'destroy'])->name('roles.destroy');
    
    
    
    // Approve and Reject
    Route::post('/admin/counselings/{id}/approve', [CounselingController::class, 'approve'])->name('counselings.approve');
    Route::post('/admin/counselings/{id}/reject', [CounselingController::class, 'reject'])->name('counselings.reject');
    Route::post('/admin/counselings/{id}/start', [CounselingController::class, 'start'])->name('counselings.start');
    Route::post('/admin/counselings/{id}/end', [CounselingController::class, 'end'])->name('counselings.end');
    
    
    
});






require __DIR__.'/auth.php';
