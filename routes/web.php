<?php


use App\Http\Livewire\Admin\AdminSettingsComponent;
use App\Http\Livewire\User\UserSettingsComponent;
use App\Http\Livewire\HomeComponent;
use App\Http\Livewire\ShopComponent;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',HomeComponent::class);
Route::get('/shop',ShopComponent::class);

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified'
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });

//for User or customer
Route::middleware(['auth:sanctum','verified'])->group(function(){
    Route::get('/user/settings',UserSettingsComponent::class)->name('user.settings');
});

//for Admin
Route::middleware(['auth:sanctum','verified'])->group(function(){
    Route::get('/admin/settings',AdminSettingsComponent::class)->name('admin.settings');
});
