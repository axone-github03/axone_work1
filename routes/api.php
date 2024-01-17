<?php

use App\Http\Controllers\API\Login\LoginController;
use App\Http\Controllers\API\Invoice\InvoiceController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "API" middleware group. Enjoy building your API!
|
 */

// user
Route::get('/get-invoice-list-new', [InvoiceController::class, "invoiceList"])->name('get.invoice.list');
Route::group(["middleware" => "api.container"], function () {

	Route::post('/login', [LoginController::class, "loginProcess"]);
	Route::post('/send-otp', [LoginController::class, "sendOTP"]);
	Route::post('/verify-otp', [LoginController::class, "verifyOTP"]);


	Route::get('/search-company', [InvoiceController::class, "searchCompany"]);
	Route::get('/search-branch', [InvoiceController::class, "searchBranch"]);
	Route::get('/search-country', [InvoiceController::class, "searchCountry"]);
	Route::get('/search-state', [InvoiceController::class, "searchState"]);
	Route::get('/search-city', [InvoiceController::class, "searchCity"]);
	Route::get('/search-printer', [InvoiceController::class, "searchPrinter"]);

	Route::post('/create-user', [LoginController::class, "createUser"])->name('create.user');
	
	Route::group(["middleware" => "auth.api"], function () {
		Route::get('/profile', [LoginController::class, "profile"])->name('api.profile');
		Route::get('/logout', [LoginController::class, "logout"]);
		Route::post('/changepassword', [LoginController::class, "changePassword"])->name('api.do.changepassword');
		Route::post('/changempin', [LoginController::class, "changempin"])->name('api.do.changempin');
		Route::post('/edit-profile', [LoginController::class, "editProfile"])->name('edit.profile');
		
		Route::get('/search-user-type', [LoginController::class, "searchUserType"]);

		// INVOICE LIST START
		Route::post('/save-invoice-list', [InvoiceController::class, "save"])->name('save.invoice.list');
		Route::get('/get-invoice-list', [InvoiceController::class, "invoiceList"])->name('get.invoice.list');
		Route::get('/get-invoice-detail', [InvoiceController::class, "InvoiceDetail"])->name('get.invoice.detail');
		Route::get('/postDownloadInvoice', [InvoiceController::class, 'postDownloadInvoice']);
		// Route::get('/DownloadInvoice', [InvoiceController::class, 'DownloadInvoice']);
		
		
		
		// INVOICE LIST END
	});
});
