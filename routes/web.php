<?php
use Illuminate\Support\Facades\Route;
use Leeuwenkasteel\Statistics\Http\Controllers\AppController;
use Leeuwenkasteel\Statistics\Livewire\Dashboard;


	Route::prefix('statistics/app')
    ->middleware(['web'])
    ->group(function () {
	
		Route::get('index', [AppController::class, 'login'])->name('statistics.login');
		
		Route::middleware('app.auth:statistics')->group(function () {
			
			
			Route::get('home', function () {
				return view('statistics::dashboard');
			})->name('statistics.home');
			
			Route::get('/revenue', [AppController::class, 'revenue'])->name('statistics.revenue');
			Route::get('/products', [AppController::class, 'products'])->name('statistics.products');
			Route::get('/suppliers', [AppController::class, 'suppliers'])->name('statistics.suppliers');
			Route::get('/payments', [AppController::class, 'payments'])->name('statistics.payments');
			Route::get('/sales-times', [AppController::class, 'salesTimes'])->name('statistics.sales-times');
			Route::get('/vat', [AppController::class, 'vat'])->name('statistics.vat');
			Route::get('/receipts', [AppController::class, 'receipts'])->name('statistics.receipts');
			Route::get('/refunds', [AppController::class, 'refunds'])->name('statistics.refunds');
			Route::get('/reports', [AppController::class, 'reports'])->name('statistics.reports');
			Route::get('logout', [AppController::class, 'logout'])->name('statistics.logout');
		});
	});
	
    Route::middleware(['web','auth'])->group(function () {
        Route::prefix('admin')->group(function () {
			Route::get('statistics/install', [AppController::class, 'index'])->name('statistics.install');
		});
	});
	