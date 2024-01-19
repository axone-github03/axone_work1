<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\InquiryCalendarController;
use App\Http\Controllers\Master\Company\CompanyController;
use App\Http\Controllers\Master\Branch\BranchController;
use App\Http\Controllers\User\UsersController;
use App\Http\Controllers\User\UsersAdminController;
use App\Http\Controllers\User\UserTypeController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Location\MasterLocationCityController;
use App\Http\Controllers\Location\MasterLocationStateController;
use App\Http\Controllers\Location\MasterLocationCountryController;


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

//Login
Route::get('/', [LoginController::class, "index"])->name('login');
Route::get('/login-with-otp', [LoginController::class, "loginWithOTP"])->name('login.otp');
Route::post('login-process', [LoginController::class, "loginProcess"])->name('login.process');
Route::post('login-otp-process', [LoginController::class, "loginWithOTPProcess"])->name('login.otp.process');
Route::get('logout', [LoginController::class, "logout"])->name('logout');
Route::get('forgot-password', [ForgotPasswordController::class, "index"])->name('forgot.password');
Route::post('resed-passswrod-link', [ForgotPasswordController::class, "resetPasswordLink"])->name('forgot.password.reset');
Route::get('reset-passswrod/{token}', [ForgotPasswordController::class, "resetPassword"])->name('reset.password');
Route::post('reset-passswrod-process', [ForgotPasswordController::class, "resetPasswordProcess"])->name('reset.password.process');

Route::get('migrate', function () {
	$data = Artisan::call('migrate');
	return "Migation Complete" . $data;
});
//Route::get('/migration-process', [MigrationProcessController::class, "index"]);

Route::group(["middleware" => "auth"], function () {
	Route::get('/dashboard', [DashboardController::class, "index"])->name('dashboard');
	Route::get('/user-detail', [DashboardController::class, "UserDetail"])->name('user.detail');

	Route::get('/dashboard-inquiry-architects-count-search-user', [DashboardInquiryArchitectsController::class, "searchUser"])->name('dashboard.inquiry.architects.count.search.user');
	Route::post('/dashboard-inquiry-architects-count-data', [DashboardInquiryArchitectsController::class, "inquiryCount"])->name('dashboard.inquiry.architects.count.data');


	Route::get('/profile', [DashboardController::class, "profile"])->name('profile');
	Route::get('/change-password', [DashboardController::class, "changePassword"])->name('changepassword');
	Route::get('/change-password-otp', [DashboardController::class, "sendOTPForChangePassword"])->name('changepassword.otp');
	Route::post('/do-change-password', [DashboardController::class, "doChangePassword"])->name('do.changepassword');


	Route::get('/company', [CompanyController::class, 'index'])->name('company.index');
	Route::post('/company-insert', [CompanyController::class, 'insert'])->name('company.insert');
	Route::get('/company-SelectCity', [CompanyController::class, 'SelectCity'])->name('company.SelectCity');
	Route::get('/company-selectSate', [CompanyController::class, 'selectSate'])->name('company.selectSate');
	Route::get('/company-searchCountry', [CompanyController::class, 'searchCountry'])->name('company.searchCountry');

	Route::post('/company-ajax', [CompanyController::class, 'ajex'])->name('company.ajax');
	Route::get('/company-editdata', [CompanyController::class, 'EditData'])->name('company.editadata');
	Route::get('/company-deleteData', [CompanyController::class, 'deleteData'])->name('company.deleteData');


	Route::get('/branch', [BranchController::class, 'index'])->name('branch.index');
	Route::post('/branch-save', [BranchController::class, 'save'])->name('branch.save');
	Route::get('/branch-select-state', [BranchController::class, 'selectState'])->name('branch.select.state');
	Route::get('/branch-select-city', [BranchController::class, 'selectCity'])->name('branch.select.city');
	// Route::get('/branch-select-country', [BranchController::class, 'selectCountry'])->name('branch.select.country');
	Route::get('/branch-select-country', [BranchController::class, 'selectCountry'])->name('branch.select.country');
	Route::get('/branch-select-company', [BranchController::class, 'selectCompany'])->name('branch.select.company');
	Route::post('/branch-ajax', [BranchController::class, 'ajax'])->name('branch.ajax');
	Route::get('/branch-delete', [BranchController::class, 'delete'])->name('branch.delete');
	Route::get('/branch-detail', [BranchController::class, 'detail'])->name('branch.detail');

	Route::get('/users-search-state', [UsersController::class, "searchState"])->name('users.search.state');
	Route::get('/users-search-city', [UsersController::class, "searchCity"])->name('users.search.city');
	Route::get('/users-search-usertype', [UsersController::class, "usertype"])->name('users.search.usertype');
	Route::get('/users-search-company', [UsersController::class, "searchCompany"])->name('users.search.company');
	Route::get('/users-search-branch', [UsersController::class, "searchBranch"])->name('users.search.branch');
	Route::get('/users-search-selectCountry', [UsersController::class, "selectCountry"])->name('users.search.selectCountry');
	Route::get('/users-search-saleperson-type', [UsersController::class, "searchSalePersonType"])->name('users.search.saleperson.type');
	Route::get('/users-search-purchaseperson-type', [UsersController::class, "searchPurchasePersonType"])->name('users.search.purcheperson.type');
	Route::get('/users-state-cities', [UsersController::class, "stateCities"])->name('users.state.cities');
	Route::get('/users-reporting-manager-sales', [UsersController::class, "salesReportingManager"])->name('users.reporting.manager');
	Route::get('/users-reporting-manager-purchase', [UsersController::class, "purchaseReportingManager"])->name('users.reporting.manager.purchase');
	Route::get('/users-search-state-cities', [UsersController::class, "searchStateCities"])->name('users.search.state.cities');
	Route::post('/user-phone-number-check', [UsersController::class, "checkUserPhoneNumberAndEmail"])->name('user.phone.number.check');
	Route::get('/users-search-service-executive-type', [UsersController::class, "searchServiceExecutiveType"])->name('users.search.service.executive.type');
	Route::get('/users-search-service-executive-reporting-manager', [UsersController::class, "searchServiceExecutiveReportingManager"])->name('users.search.service.executive.reporting.manager');

	Route::post('/users-save', [UsersController::class, "save"])->name('users.save');
	Route::get('/users-detail', [UsersController::class, "detail"])->name('users.detail');

	Route::get('/users-admin', [UsersAdminController::class, "index"])->name('users.admin');
	Route::post('/users-admin-ajax', [UsersAdminController::class, "ajax"])->name('users.admin.ajax');
	Route::get('/users-admin-export', [UsersAdminController::class, "export"])->name('users.admin.export');

	// Route::get('/user-type', [UserTypeController::class, 'index'])->name('user.type.index');
	// Route::post('/user-type-save', [UserTypeController::class, 'save'])->name('user.type.save');
	// Route::post('/user-type-ajax', [UserTypeController::class, 'ajax'])->name('user.type.ajax');
	// Route::get('/user-type-delete', [UserTypeController::class, 'delete'])->name('user.type.delete');
	// Route::get('/user-type-detail', [UserTypeController::class, 'detail'])->name('user.type.detail');


	Route::get('/users-order', [OrderController::class, "index"])->name('users.order.index');
	Route::post('/users-order-ajax', [OrderController::class, "ajax"])->name('users.order.ajax');
	Route::get('/users-order-edite', [OrderController::class, 'orderEdite'])->name('users.order.orderEdite');
	Route::get('/users-order-pdf', [OrderController::class, 'invoicePDF'])->name('users.order.invoicePDF');
	Route::post('/users-order-active', [OrderController::class, 'invoiceActive'])->name('users.order.active');


	Route::get('/order-add', [OrderController::class, "add"])->name('add.order');
	Route::get('/order-company-detail', [OrderController::class, "compnayDetail"])->name('order.company.detail');
	Route::get('/order-branch-detail', [OrderController::class, "detail"])->name('order.branch.detail');
	Route::get('/order-select-state', [OrderController::class, 'selectState'])->name('order.select.state');
	Route::get('/order-select-city', [OrderController::class, 'selectCity'])->name('order.select.city');
	Route::get('/order-select-country', [OrderController::class, 'selectCountry'])->name('order.select.country');
	Route::post('/order-calculation', [OrderController::class, "calculation"])->name('order.calculation');
	Route::post('/orders-save', [OrderController::class, "save"])->name('order.save');




	/// START Country List
	Route::get('/master-location-country', [MasterLocationCountryController::class, "index"])->name('countrylist');
	Route::post('/master-location-country-ajax', [MasterLocationCountryController::class, "ajax"])->name('countrylist.ajax');
	Route::post('/master-location-country-save', [MasterLocationCountryController::class, "save"])->name('countrylist.save');
	Route::get('/master-location-country-edite', [MasterLocationCountryController::class, "edite"])->name('countrylist.edite');
	/// END Country List

	/// START State List
	Route::get('/master-location-state', [MasterLocationStateController::class, "index"])->name('statelist');
	Route::get('/master-location-select-country', [MasterLocationStateController::class, "selectCountry"])->name('selectCountry');
	Route::post('/master-location-state-ajax', [MasterLocationStateController::class, "ajax"])->name('statelist.ajax');
	Route::post('/master-location-state-save', [MasterLocationStateController::class, "save"])->name('statelist.save');
	Route::get('/master-location-state-edite', [MasterLocationStateController::class, "edite"])->name('statelist.edite');
	/// END State List

	/// START CITY LIST
	Route::get('/master-location-city', [MasterLocationCityController::class, "index"])->name('citylist');
	Route::get('/master-location-city-search-state', [MasterLocationCityController::class, "searchState"])->name('citylist.search.state');
	Route::post('/master-location-city-ajax', [MasterLocationCityController::class, "ajax"])->name('citylist.ajax');
	Route::get('/master-location-city-search-country', [MasterLocationCityController::class, "searchCountry"])->name('citylist.search.country');
	Route::post('/master-location-city-save', [MasterLocationCityController::class, "save"])->name('citylist.save');
	Route::get('/master-location-state-list', [MasterLocationCityController::class, "statList"])->name('citylist.statList');
	Route::get('/master-location-city-detail', [MasterLocationCityController::class, "detail"])->name('citylist.detail');
	/// END CITY LIST

});
