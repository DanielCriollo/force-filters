<?php

use TCG\Voyager\Facades\Voyager;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Home\HomeComponent;
use App\Livewire\Admin\Sales\SalesComponent;
use App\Livewire\Admin\Brands\BrandComponent;
use App\Livewire\Admin\Products\ProductComponent;
use App\Livewire\Admin\Customers\CustomerComponent;
use App\Livewire\Admin\Sales\SalesProductsComponent;
use App\Http\Controllers\Admin\Sales\SalesController;
use App\Livewire\Admin\Products\ProductTypeComponent;
use App\Livewire\Admin\Products\ProductCategoryComponent;

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

/* Route::get('/', function () {
    return view('welcome');
}); */


Route::group(['prefix' => 'admin'], function () {
    Route::get('/c/customers',CustomerComponent::class)->name('customers');
    Route::get('/c/product-types',ProductTypeComponent::class)->name('product-types');
    Route::get('/c/product-categories',ProductCategoryComponent::class)->name('product-categories');

    Route::get('/c/products',ProductComponent::class)->name('products');

    Route::get('/sales-products',SalesProductsComponent::class)->name('sales.products');

    Voyager::routes();
});

Route::group(['prefix' => 'system'], function () {
    Route::get('/',HomeComponent::class)->name('system.home');

    Route::get('/customers',CustomerComponent::class)->name('customers');
    Route::get('/brands',BrandComponent::class)->name('brands');
    Route::get('/product-types',ProductTypeComponent::class)->name('product-types');

    Route::get('/sales',SalesComponent::class)->name('sales');
    Route::get('/sales-products',SalesProductsComponent::class)->name('sales.products');
    Route::get('/product-categories',ProductCategoryComponent::class)->name('product-categories');

});

Route::get('sales/{id}/invoice', [SalesController::class, 'downloadInvoice'])->name('sales.invoice');