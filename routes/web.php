<?php

use App\SalesOrder;
use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('home');
    }
    return redirect()->route('login');
});

Route::group(['prefix' => 'system'], function () {
    Voyager::routes();
});

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::get('/',HomeComponent::class)->name('home');

    Route::get('/customers',CustomerComponent::class)->name('customers');
    Route::get('/brands',BrandComponent::class)->name('brands');
    Route::get('/product-types',ProductTypeComponent::class)->name('product-types');

    Route::get('/sales/{status?}',SalesComponent::class)->name('sales');
    Route::get('/sales-products',SalesProductsComponent::class)->name('sales-products');
    Route::get('/sales-products/{id}/update',SalesProductsComponent::class)->name('sales-products.update');
    Route::get('/product-categories',ProductCategoryComponent::class)->name('product-categories');
    Route::get('/products',ProductComponent::class)->name('products');
});

Route::get('sales/{uuid}/invoice', [SalesController::class, 'downloadInvoice'])->name('sales.invoice');

Auth::routes();

Route::get('/update-invoice-numbers', function () {
    $orders = SalesOrder::orderBy('id')->get();
    foreach ($orders as $index => $order) {
        $order->invoice_number = 'FV-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT);
        $order->save();
    }

    return 'Invoice numbers updated successfully!';
});

Route::get('/whatsapp-webhook', function (Request $request) {
    $verifyToken = 'Ducker++2024';

    try {
        $mode = $request->query('hub_mode');
        $token = $request->query('hub_verify_token');
        $challenge = $request->query('hub_challenge');

        if ($mode && $token) {
            if ($mode === 'subscribe' && $token === $verifyToken) {
                // Validación exitosa
                return response($challenge, 200)
                    ->header('Content-Type', 'text/plain');
            }
        }

        // Si no se cumple la condición, lanza una excepción
        throw new Exception('Invalid mode or token');
    } catch (\Throwable $th) {
        // Loguear el error para seguimiento
        Log::error('Webhook validation failed: ', [
            'error' => $th->getMessage(),
            'request' => $request->all()
        ]);

        return response()->json([
            'success' => false,
            'error' => $th->getMessage(),
        ], 500);
    }
});