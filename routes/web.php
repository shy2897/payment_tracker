<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminPanel\AdminController;
use App\Http\Controllers\AdminPanel\AdminAnnualController;
use App\Http\Controllers\AdminPanel\AdminChangeController;
use App\Http\Controllers\SuperPanel\SuperController;
use App\Http\Controllers\UserPanel\ProductController;
use App\Http\Controllers\UserPanel\AnnualController;
use App\Http\Controllers\UserPanel\ChangeController;
use App\Http\Controllers\UserPanel\CapexController;
use App\Http\Controllers\UserPanel\OpexController;


use App\Http\Controllers\Auth\RegisteredUserController;



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
    return view('auth.login');
});

Route::get('/previous-page', 'BackButtonController@redirectToPreviousPage')->name('previous.page');

Route::middleware(['auth', 'role:user'])->group(function () {
    // Route::get('/dashboard', function () {return view('dashboard');})->name('dashboard');
    
    Route::get('/dashboard',[HomeController::class, 'index'])->name('dashboard');

    //MRC
    Route::get('/mrc',[ProductController::class, 'index'])->name('product');
    Route::get('/mrc/create',[ProductController::class, 'create'])->name('products.create');
    Route::get('/mrc/create_approval',[ProductController::class, 'create_approval'])->name('products.create');
    Route::post('/mrc/store',[ProductController::class, 'store'])->name('products.store');
    Route::get('/mrc/{id}/edit',[ProductController::class,'edit']);
    Route::put('/mrc/{id}/update',[ProductController::class,'update']);
    Route::delete('/mrc/{id}/delete',[ProductController::class,'destroy']);
    Route::get('/mrc/{id}/show',[ProductController::class,'show']);
    Route::get('/mrc/search_data',[ProductController::class,'search_data']);
    Route::get('/mrc/generatePdf/{year}/{month}',[ProductController::class, 'generatePdf'])->name('generatePdf');
    Route::get('/test',[ProductController::class, 'test'])->name('products.test');
    Route::post('/mrc/budget_edit/{budgetId}', [ProductController::class, 'budget'])->name('product.budget_edit');
    Route::post('/mrc/{id}/usd_rate', [ProductController::class, 'usd_rate'])->name('product.budget_edit');
    Route::post('mrc/{id}/approve',[ProductController::class,'approve']);
    Route::post('mrc/{id}/reject',[ProductController::class,'reject']);
    Route::post('/mrc/sub_category',[ProductController::class,'sub_category']);
    Route::get('/mrc/subcategories/{year}/{category}', [ProductController::class,'sub_category_year']);
    Route::post('/mrc/category_budget_edit/{budgetId}', [ProductController::class, 'sub_category_budget']);

    //Annual_Capex
    Route::get('/annual_capex',[AnnualController::class, 'index'])->name('annual.index');
    Route::get('/annual_capex/create',[AnnualController::class, 'create'])->name('annuals.create');
    Route::post('/annual_capex/store',[AnnualController::class, 'store'])->name('annuals.store');
    Route::get('/annual_capex/{id}/edit',[AnnualController::class,'edit']);
    Route::put('annual_capex/{id}/update',[AnnualController::class,'update']);
    Route::delete('/annual_capex/{id}/delete',[AnnualController::class,'destroy']);
    Route::get('/annual_capex/{id}/show',[AnnualController::class,'show']);
    Route::get('/annual_capex/search_data',[AnnualController::class,'search_data']);
    Route::get('/annual_capex/generatePdf/{year}/{month}',[AnnualController::class, 'generatePdf'])->name('annual_capex.generatePdf');
    Route::post('/annual_capex/budget_edit/{budgetId}', [AnnualController::class, 'budget'])->name('product.budget_edit');
    Route::post('/annual_capex/{id}/usd_rate', [AnnualController::class, 'usd_rate'])->name('product.budget_edit');
    Route::post('annual_capex/{id}/approve',[AnnualController::class,'approve']);
    Route::post('annual_capex/{id}/reject',[AnnualController::class,'reject']);
    Route::post('/annual_capex/sub_category',[AnnualController::class,'sub_category']);
    Route::get('/annual_capex/subcategories/{year}/{category}', [AnnualController::class,'sub_category_year']);
    Route::post('/annual_capex/category_budget_edit/{budgetId}', [AnnualController::class, 'sub_category_budget']);

     //AMC
     Route::get('/amc',[ChangeController::class, 'index'])->name('change.index');
     Route::get('/amc/create',[ChangeController::class, 'create'])->name('change.create');
     Route::post('/amc/store',[ChangeController::class, 'store'])->name('change.store');
     Route::get('/amc/{id}/edit',[ChangeController::class,'edit']);
     Route::put('amc/{id}/update',[ChangeController::class,'update']);
     Route::delete('/amc/{id}/delete',[ChangeController::class,'destroy']);
     Route::get('/amc/{id}/show',[ChangeController::class,'show']);
     Route::get('/amc/search_data',[ChangeController::class,'search_data']);
     Route::get('/amc/generatePdf/{year}/{month}',[ChangeController::class, 'generatePdf'])->name('amc.generatePdf');
     Route::post('/amc/budget_edit/{budgetId}', [ChangeController::class, 'budget'])->name('product.budget_edit');
     Route::post('/amc/{id}/usd_rate', [ChangeController::class, 'usd_rate'])->name('product.budget_edit');
     Route::post('amc/{id}/approve',[ChangeController::class,'approve']);
     Route::post('amc/{id}/reject',[ChangeController::class,'reject']);
     Route::post('/amc/sub_category',[ChangeController::class,'sub_category']);
     Route::get('/amc/subcategories/{year}/{category}', [ChangeController::class,'sub_category_year']);
     Route::post('/amc/category_budget_edit/{budgetId}', [ChangeController::class, 'sub_category_budget']);
     

     //Project_Capex
    Route::get('/project_capex',[CapexController::class, 'index'])->name('product');
    Route::get('/project_capex/create',[CapexController::class, 'create'])->name('products.create');
    Route::post('/project_capex/store',[CapexController::class, 'store'])->name('products.store');
    Route::get('project_capex/{id}/edit',[CapexController::class,'edit']);
    Route::put('project_capex/{id}/update',[CapexController::class,'update']);
    Route::delete('project_capex/{id}/delete',[CapexController::class,'destroy']);
    Route::get('project_capex/{id}/show',[CapexController::class,'show']);
    Route::get('project_capex/search_data',[CapexController::class,'search_data']);
    Route::get('project_capex/generatePdf/{year}/{month}',[CapexController::class, 'generatePdf'])->name('project_capex.generatePdf');
    Route::post('/project_capex/budget_edit/{budgetId}', [CapexController::class, 'budget'])->name('product.budget_edit');
    Route::post('/project_capex/{id}/usd_rate', [CapexController::class, 'usd_rate'])->name('product.budget_edit');
    Route::post('project_capex/{id}/approve',[CapexController::class,'approve']);
    Route::post('project_capex/{id}/reject',[CapexController::class,'reject']);
    Route::post('/project_capex/sub_category',[CapexController::class,'sub_category']);
    Route::get('/project_capex/subcategories/{year}/{category}', [CapexController::class,'sub_category_year']);
    Route::post('/project_capex/category_budget_edit/{budgetId}', [CapexController::class, 'sub_category_budget']);
    

    //Project_Opex
    Route::get('/project_opex',[OpexController::class, 'index'])->name('product');
    Route::get('/project_opex/create',[OpexController::class, 'create'])->name('products.create');
    Route::post('/project_opex/store',[OpexController::class, 'store'])->name('products.store');
    Route::get('project_opex/{id}/edit',[OpexController::class,'edit']);
    Route::put('project_opex/{id}/update',[OpexController::class,'update']);
    Route::delete('project_opex/{id}/delete',[OpexController::class,'destroy']);
    Route::get('project_opex/{id}/show',[OpexController::class,'show']);
    Route::get('project_opex/search_data',[OpexController::class,'search_data']);
    Route::get('project_opex/generatePdf/{year}/{month}',[OpexController::class, 'generatePdf'])->name('project_opex.generatePdf');
    Route::post('/project_opex/budget_edit/{budgetId}', [OpexController::class, 'budget'])->name('product.budget_edit');
    Route::post('/project_opex/{id}/usd_rate', [OpexController::class, 'usd_rate'])->name('product.budget_edit');
    Route::post('project_opex/{id}/approve',[OpexController::class,'approve']);
    Route::post('project_opex/{id}/reject',[OpexController::class,'reject']);
    Route::post('/project_opex/sub_category',[OpexController::class,'sub_category']);
    Route::get('/project_opex/subcategories/{year}/{category}', [OpexController::class,'sub_category_year']);
    Route::post('/project_opex/category_budget_edit/{budgetId}', [OpexController::class, 'sub_category_budget']);
    
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin/dashboard',[HomeController::class, 'admin'])->name('admin.dashboard');

    //New Project
    Route::get('/admin/product',[AdminController::class, 'index'])->name('admin.product');
    Route::get('/admin/products/{id}/show',[AdminController::class,'show']);
    Route::get('/admin/search_data',[AdminController::class,'search_data']);
    Route::get('/admin/generatePdf/{year}/{month}',[AdminController::class, 'generatePdf'])->name('admin.generatePdf');
    // Route::post('products/{id}/approve',[AdminController::class,'approve']);
    // Route::post('products/{id}/reject',[AdminController::class,'reject']);

    //Annual
    Route::get('/admin/annual/dashboard',[AdminAnnualController::class, 'index'])->name('admin.annual.dashboard');
    Route::get('/admin/annual/{id}/show',[AdminAnnualController::class,'show']);
    Route::get('/admin/annual/search_data',[AdminAnnualController::class,'search_data']);
    Route::get('/admin/annual/generatePdf/{year}/{month}',[AdminAnnualController::class, 'generatePdf'])->name('admin.annual.generatePdf');
    // Route::post('annual/{id}/approve',[AdminAnnualController::class,'approve']);
    // Route::post('annual/{id}/reject',[AdminAnnualController::class,'reject']);

    //Change
    Route::get('/admin/change/dashboard',[AdminChangeController::class, 'index'])->name('admin.change.dashboard');
    Route::get('/admin/change/{id}/show',[AdminChangeController::class,'show']);
    Route::get('/admin/change/search_data',[AdminChangeController::class,'search_data']);
    Route::get('/admin/change/generatePdf/{year}/{month}',[AdminChangeController::class, 'generatePdf'])->name('admin.change.generatePdf');
    // Route::post('change/{id}/approve',[AdminChangeController::class,'approve']);
    // Route::post('change/{id}/reject',[AdminChangeController::class,'reject']);
    
});

Route::middleware(['auth', 'role:super'])->group(function () {

    Route::get('/super/dashboard',[SuperController::class, 'index'])->name('super.dashboard');
});
