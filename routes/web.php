<?php

use Illuminate\Support\Facades\Route;


Auth::routes();

Route::get('/', 'HomeController@redirectAdmin')->name('index');
Route::get('/home', 'HomeController@index')->name('home');

/**
 * Admin routes
 */
Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'Backend\DashboardController@index')->name('admin.dashboard');
    Route::resource('roles', 'Backend\RolesController', ['names' => 'admin.roles']);
    Route::resource('users', 'Backend\UsersController', ['names' => 'admin.users']);
    Route::resource('admins', 'Backend\AdminsController', ['names' => 'admin.admins']);
    Route::resource('products', 'Backend\MasterProductController', ['names' => 'admin.products']);
    Route::resource('lendings', 'Backend\LendingController', ['names' => 'admin.lendings']);
    Route::resource('companies', 'Backend\CompaniesController', ['names' => 'admin.companies']);
    Route::resource('borrowers', 'Backend\BorrowersController', ['names' => 'admin.borrowers']);
    Route::resource('lendingFunding', 'Backend\LendingFundingController', ['names' => 'admin.lendingFunding']);
    Route::resource('lendingPayment', 'Backend\LendingPaymentController', ['names' => 'admin.lendingPayment']);
    Route::resource('cif', 'Backend\CifController', ['names' => 'admin.cif']);
    Route::resource('kyc', 'Backend\KycController', ['names' => 'admin.kyc']);
    Route::resource('productBej', 'Backend\ProductBejController', ['names' => 'admin.productBej']);

    Route::post('generate', 'Backend\MasterProductController@generate')->name('admin.generate');
    Route::post('product_interest_items', 'Backend\MasterProductController@product_interest')->name('admin.product_interest');
    Route::post('ProductInterestItems', 'Backend\MasterProductController@ProductInterestItems')->name('admin.ProductInterestItems');
    Route::post('simulasi', 'Backend\MasterProductController@simulasi')->name('admin.simulasi');

    Route::get('list_lendingFunding_json', 'Backend\LendingFundingController@list_lending_json')->name('admin.list_lendingFunding_json');

    Route::get('list_lending_json', 'Backend\LendingController@list_lending_json')->name('admin.list_lending_json');
    Route::post('getLending', 'Backend\LendingController@getLending')->name('admin.getLending');
    Route::post('confirms', 'Backend\LendingController@confirms')->name('admin.confirms');
    Route::post('reject', 'Backend\LendingController@reject')->name('admin.reject');

    Route::post('getCompany', 'Backend\CompaniesController@getCompany')->name('admin.getCompany');
    Route::get('list_json_companies', 'Backend\CompaniesController@list_json')->name('admin.list_json_companies');
    Route::post('list_borrowers_json_product', 'Backend\BorrowersController@list_borrowers_json_product')->name('admin.list_borrowers_json_product');
    Route::get('list_borrowers_json', 'Backend\BorrowersController@list_borrowers_json')->name('admin.list_borrowers_json');

    Route::get('list_borrower', 'Backend\BorrowersController@list_borrower_json')->name('admin.list_borrower_json');
    Route::resource('borrowers', 'Backend\BorrowersController', ['names' => 'admin.borrowers']);
    Route::post('getBorrower', 'Backend\BorrowersController@getBorrower')->name('admin.getBorrower');

    // Route::get('ajax_list_borrower', [MasterProductController::class, 'generatorCodeItem'])->name('masterproduct.generatorCodeItem');


    // Login Routes
    Route::get('/login', 'Backend\Auth\LoginController@showLoginForm')->name('admin.login');
    Route::post('/login/submit', 'Backend\Auth\LoginController@login')->name('admin.login.submit');

    // Logout Routes
    Route::post('/logout/submit', 'Backend\Auth\LoginController@logout')->name('admin.logout.submit');

    // Forget Password Routes
    // Route::get('/password/reset', 'Backend\Auth\ForgetPasswordController@showLinkRequestForm')->name('admin.password.request');
    // Route::post('/password/reset/submit', 'Backend\Auth\ForgetPasswordController@reset')->name('admin.password.update');
});
