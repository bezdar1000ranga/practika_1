<?php

use Src\Route;

Route::add('GET', '/hello', [Controller\Site::class, 'hello'])->middleware('auth');
Route::add(['GET', 'POST'], '/signup', [Controller\Site::class, 'signup']);
Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add(['GET', 'POST'], '/student', [Controller\Site::class, 'student']);
Route::add(['GET', 'POST'], '/discipline', [Controller\Site::class, 'discipline']);
Route::add(['GET', 'POST'], '/group', [Controller\Site::class, 'group']);
Route::add(['GET', 'POST'], '/performance', [Controller\Site::class, 'performance']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);
Route::add(['GET', 'POST'], '/student-list', [Controller\Site::class, 'student_list']);
Route::add(['GET', 'POST'], '/discipline-list', [Controller\Site::class, 'discipline_list']);
Route::add(['GET', 'POST'], '/student-group', [Controller\Site::class, 'student_group']);
Route::add(['GET', 'POST'], '/poisk', [Controller\Site::class, 'poisk']);
