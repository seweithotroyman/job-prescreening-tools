<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\UploadJobPost;
use App\Livewire\UploadResume;
use App\Http\Controllers\JobFitController;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    // ✅ Upload Job Description
    Route::get('/posts', UploadJobPost::class)
        ->name('posts.upload');
    // ✅ Upload Resume
    Route::get('/resume', UploadResume::class)
        ->name('resume.upload');
});

Route::get('/jobfit/{jobPost}/{resume}', [JobFitController::class, 'show'])
    ->name('jobfit.show');
    
Route::post('/jobfit/{jobPost}/{resume}', [JobFitController::class, 'analyze'])
    ->name('jobfit.analyze');

Route::get('/chatgpt', [JobFitController::class, 'chatGpt'])
    ->name('chatgpt');