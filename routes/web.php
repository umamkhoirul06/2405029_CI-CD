<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
// Jangan lupa import model yang dibutuhkan di atas

Route::get('/dashboard', function () {
    $stats = [
        'categories' => Category::count(),
        'posts' => Post::count(),
        'tags' => Tag::count(),
        'users' => User::count(),
        'subscribers' => 10, // Ganti dengan Model Subscriber kamu jika sudah buat tabelnya
    ];

    return view('admin.dashboard', compact('stats'));
})->middleware(['auth', 'verified'])->name('dashboard');
require __DIR__ . '/front.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/auth.php';
