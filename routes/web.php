<?php

use Illuminate\Support\Facades\Route;

Route::view('/','index');

Route::resource('authors','AuthorController');
Route::resource('books','BookController');
