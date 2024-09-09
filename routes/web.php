<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ClientController;

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

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::group(['middleware' => ['can:view all invoice']], function () { 
Route::get('/invoices/{id?}', [InvoiceController::class, 'index'])->name('all.invoices');
Route::get('/invoices/update/status/{id}', [InvoiceController::class, 'updateStatus'])->name('change.invoices');
Route::get('/invoices/{id}', [InvoiceController::class, 'show'])->name('show.invoices');
Route::post('/invoice/create', [InvoiceController::class, 'store'])->name('create.invoices');
Route::get('/items', [ItemController::class, 'index'])->name('items');
Route::post('/invoice/{id}/update', [InvoiceController::class, 'update'])->name('update.invoices');
 });
 Route::group([ 'middleware' => ['role:Super-Admin']], function () { 
    Route::post('/invoice/{id}/delete', [InvoiceController::class, 'destroy'])->name('delete.invoices');
    Route::get('/clients', [ClientController::class, 'index'])->name('all.clients');
    Route::get('/clients/{id}', [ClientController::class, 'show'])->name('show.invoices');
    Route::post('/clients/create', [ClientController::class, 'store'])->name('create.clients');
    Route::post('/clients/{id}/update', [ClientController::class, 'update'])->name('update.clients');
    Route::post('/clients/{id}/delete', [ClientController::class, 'destroy'])->name('delete.clients');

     });