<?php

use App\Livewire\Auth\ForgotPasswordPage;
use App\Livewire\Auth\LoginPage;
use App\Livewire\Auth\RegisterPage;
use App\Livewire\Auth\ResetPasswordPage;
use App\Livewire\CancelPage;
use App\Livewire\CartPage;
use App\Livewire\CategoiresPage;
use App\Livewire\CheckoutPage;
use App\Livewire\HomePage;
use App\Livewire\MyOrderDetailPage;
use App\Livewire\MyOrderPage;
use App\Livewire\ProductDetailPage;
use App\Livewire\ProductsPage;
use App\Livewire\SucessPage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get("/", HomePage::class);
Route::get("/categories", CategoiresPage::class);
Route::get("/products", ProductsPage::class);
Route::get("/products/{slug}", ProductDetailPage::class);
Route::get("/cart", CartPage::class);

Route::get("/login-page", MyOrderDetailPage::class);


Route::middleware('guest')->group(function () {
    Route::get("/login", LoginPage::class);
    Route::get("/register", RegisterPage::class);
    Route::get("/forgot", ForgotPasswordPage::class)->name('password.request');
    Route::get("/reset/{token}", ResetPasswordPage::class)->name('password.reset');
});


Route::middleware('auth')->group(function () {

    Route::get('/logout', function () {
        Auth::logout();
        return redirect('/');
    });

    Route::get("/checkout", CheckoutPage::class);
    Route::get("/my-order", MyOrderPage::class);
    Route::get("/my-order/{order}", MyOrderDetailPage::class);

    Route::get("/sucess", SucessPage::class);
    Route::get("/cancel", CancelPage::class);
});
