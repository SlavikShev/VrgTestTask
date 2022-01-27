<?php

use Illuminate\Support\Facades\Route;

Route::resource('authors','AuthorController');
Route::resource('books','BookController');
