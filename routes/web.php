<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CommandController;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\ProductController;
use App\Http\Livewire\ProductDetailComponent;
use App\Http\Livewire\AboutComponent;
use App\Http\Livewire\ContactUs;
use App\Http\Livewire\Checkout;
use App\Http\Livewire\FaqComponent;
use App\Http\Livewire\TermsComponent;
use App\Http\Livewire\PrivacyComponent;
use App\Http\Livewire\Admin\AdminSettingsComponent;
use App\Http\Livewire\Admin\AdminContactUs;
use App\Http\Livewire\User\UserSettingsComponent;
use App\Http\Livewire\HomeComponent;
use App\Http\Livewire\ShopComponent;
use GuzzleHttp\Middleware;
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
Route::middleware('notAdmin')->group(function(){
    Route::get('/',HomeComponent::class);
    Route::get('/shop', ShopComponent::class);
    Route::get('/about',AboutComponent::class);
    Route::get('/faq',FaqComponent::class);
    Route::get('/terms',TermsComponent::class);
    Route::get('/privacy',PrivacyComponent::class);
    //Route::get('/product/detail/{id}', [ProductDetailComponent::class, 'prod'])->name('details');
    Route::get('/contact-us',ContactUs::class);

    Route::get('/product_details/{id}',[ProductDetailComponent::class,'product_details']);
    Route::post('/add_card/{id}',[ProductDetailComponent::class,'add_card']);
});


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
    Route::get('/checkout',Checkout::class)->middleware('notAdmin');
});

//for Admin
Route::middleware(['auth:sanctum','verified'])->group(function(){
    Route::get('/admin/settings',AdminSettingsComponent::class)->name('admin.settings');

});

Route::middleware('admin')->group(function(){
    //Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/products', [CrudController::class, 'products'])->name('products');
    Route::get('/categories', [CrudController::class, 'categories'])->name('categories');
    Route::get('/clients', [CrudController::class, 'clients'])->name('clients');
    Route::get('/commands', [CrudController::class, 'commands'])->name('commands');
    Route::get('/admin/contact-us', [AdminContactUs::class, 'admin.contact'])->name('admin.contact');

});