<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
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

// routes/web.php
Route::get('/login', [AuthController::class,'loginForm'])->name('login');
Route::post('/login', [AuthController::class,'login']);
Route::get('/logout', [AuthController::class,'logout'])->name('logout');
Route::middleware(['auth','check_access_token_expiration'])->group(function () {
    Route::get('/',[AuthorController::class,'index'])->name('dashboard');
    //Authors
    Route::get('/author/delete/{author_id}',[AuthorController::class,'deleteAuthor'])->name('author.delete');
    Route::get('/author/{author_id}/books',[AuthorController::class,'getBooks'])->name('author.books');
    //Books
    Route::get('/book/delete/{book_id}',[BookController::class,'deleteBook'])->name('delete.book');
    Route::get('/book/add',[BookController::class,'showAddBookForm'])->name('show.add_book');
    Route::post('/book/add',[BookController::class,'addBook'])->name('add.book');
    //Profile
    Route::get('/profile',[ProfileController::class,'showProfile'])->name('profile');
});