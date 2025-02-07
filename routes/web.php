<?php

use App\Models\Blog;
use App\Models\Note;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::view('/', 'welcome')
    ->name('welcome');

Route::view('/dashboard', 'dashboard')
    ->middleware(['auth', 'verified','admin'])
    ->name('dashboard');

Route::view('/notes', 'Notes.index')
    ->middleware(['auth', 'verified'])
    ->name('notes.index');

Route::view('/notes/create', 'Notes.create')
    ->middleware(['auth', 'verified','admin'])
    ->name('notes.create');

Route::view('/profile', 'profile')
    ->middleware(['auth','verified'])
    ->name('profile');

Volt::route('/notes/{note}/edit', 'notes.edit-note')
    ->middleware(['auth', 'verified','admin'])
    ->name('notes.edit');

Route::get('/notes/{note}',function (Note $note){
    if(!$note->is_published){
        abort(404);
    }
    $user=$note->user;

    return view('Notes.show',compact(['note','user']));
    })->name('notes.show');

//Route::view('/notes/{note}', 'notes.show');

Route::view('/blogs', 'Blog.index')
    ->name('blogs');
Route::view('/blogs/create', 'Blog.create')
    ->middleware(['auth', 'verified','admin'])
    ->name('blogs.create');
Route::get('/blogs/{blog}', function (Blog $blog) {
    return view('Blog.show',['blogId' => $blog->id]);
})->name('blogs.show');

Volt::route('/blogs/{blog}/edit', 'blog.edit')
    ->middleware(['auth', 'verified','admin'])
    ->name('blog.edit');

Volt::route('/comments/{comment}/edit', 'comments.edit')
    ->middleware(['auth', 'verified'])
    ->name('comment.edit');


Route::view('/comments', 'Comments.index')
    ->name('comments');
Route::view('/comment/create', 'Comments.create')
    ->name('comment.create');
Route::view('/comment/{comment}', 'Comments.show')
    ->name('comment.show');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::view('/chat', 'chat')
    ->name('chat');


require __DIR__.'/auth.php';
