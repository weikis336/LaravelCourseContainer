<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  return view('welcome');
});
Route::get('/faqs', function () {
  $faqs = \App\Models\Faqs::all();
  return view('faqs.index', compact('faqs'));
})->name('faqs');

Route::group(['prefix' => 'admin', 'middleware' => ['auth:web']], function () {
  Route::get('/dashboard', function () {
    return view('admin.dashboard.index');
  })->name('dashboard');

  Route::resource('usuarios', 'App\Http\Controllers\Admin\UserController', [
    'parameters' => [
      'usuarios' => 'user',
    ],
    'names' => [
      'index' => 'users',
      'create' => 'users_create',
      'edit' => 'users_edit',
      'store' => 'users_store',
      'destroy' => 'users_destroy',
    ]
  ]);
  Route::resource('faqs', 'App\Http\Controllers\Admin\FaqsController', [
    'parameters' => [
      'faqs' => 'faqs',
    ],
    'names' => [
      'index' => 'faqs',
      'create' => 'faqs_create',
      'edit' => 'faqs_edit',
      'store' => 'faqs_store',
      'destroy' => 'faqs_destroy',
    ]
  ]);
  Route::get('/web-stats', function () {
    return view('admin.stats.web');
  })->name('web-stats');
  Route::get('/downloads-stats', function () {
    return view('admin.stats.download');
  })->name('downloads-stats');
});

Route::get('/admin', function () {
  return view('admin.dashboard.index');
})->middleware('auth:web');


Route::group(['prefix' => 'cuenta', 'middleware' => ['auth:customer']], function () {
  Route::get('/dashboard', function () {
    return view('customer.dashboard.index');
  })->name('customer-dashboard');
});

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware('auth-customer')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__ . '/auth.php';
require __DIR__ . '/auth-customer.php';