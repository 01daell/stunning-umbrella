<?php

use App\Http\Controllers\App\BillingController;
use App\Http\Controllers\App\BrandKitController;
use App\Http\Controllers\App\BrandKitExportController;
use App\Http\Controllers\App\BrandKitShareController;
use App\Http\Controllers\App\DashboardController;
use App\Http\Controllers\App\SettingsController;
use App\Http\Controllers\App\WorkspaceMemberController;
use App\Http\Controllers\App\WorkspaceSwitchController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\InstallController;
use App\Http\Controllers\MarketingController;
use App\Http\Controllers\ShareController;
use App\Http\Controllers\StripeWebhookController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MarketingController::class, 'landing'])->name('landing');
Route::get('/pricing', [MarketingController::class, 'pricing'])->name('pricing');
Route::get('/faq', [MarketingController::class, 'faq'])->name('faq');

Route::middleware('installer')->group(function () {
    Route::get('/install', [InstallController::class, 'index'])->name('install.index');
    Route::post('/install', [InstallController::class, 'store'])->name('install.store');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');

Route::get('/share/{token}', [ShareController::class, 'show'])->name('share.show');
Route::get('/share/{token}/zip', [ShareController::class, 'downloadZip'])->name('share.zip');

Route::post('/stripe/webhook', StripeWebhookController::class)->name('stripe.webhook');

Route::middleware(['auth', 'installed'])->prefix('app')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('app.dashboard');
    Route::post('/workspace/switch', WorkspaceSwitchController::class)->name('app.workspace.switch');

    Route::get('/kits/create', [BrandKitController::class, 'create'])->name('app.kits.create');
    Route::post('/kits', [BrandKitController::class, 'store'])->name('app.kits.store');
    Route::get('/kits/{kit}', [BrandKitController::class, 'show'])->name('app.kits.show');
    Route::put('/kits/{kit}', [BrandKitController::class, 'update'])->name('app.kits.update');
    Route::delete('/kits/{kit}', [BrandKitController::class, 'destroy'])->name('app.kits.destroy');

    Route::post('/kits/{kit}/assets', [BrandKitController::class, 'storeAsset'])->middleware('throttle:10,1')->name('app.kits.assets.store');
    Route::delete('/kits/{kit}/assets/{asset}', [BrandKitController::class, 'destroyAsset'])->name('app.kits.assets.destroy');

    Route::post('/kits/{kit}/colors', [BrandKitController::class, 'storeColor'])->name('app.kits.colors.store');
    Route::delete('/kits/{kit}/colors/{color}', [BrandKitController::class, 'destroyColor'])->name('app.kits.colors.destroy');

    Route::put('/kits/{kit}/fonts', [BrandKitController::class, 'updateFonts'])->name('app.kits.fonts.update');

    Route::get('/kits/{kit}/export', [BrandKitExportController::class, 'export'])->middleware('throttle:8,1')->name('app.kits.export');
    Route::get('/kits/{kit}/export/zip', [BrandKitExportController::class, 'zip'])->middleware('throttle:4,1')->name('app.kits.export.zip');
    Route::post('/kits/{kit}/templates', [BrandKitExportController::class, 'templates'])->middleware('throttle:4,1')->name('app.kits.templates');

    Route::get('/kits/{kit}/share', [BrandKitShareController::class, 'index'])->name('app.kits.share');
    Route::post('/kits/{kit}/share', [BrandKitShareController::class, 'store'])->middleware('throttle:5,1')->name('app.kits.share.store');
    Route::put('/kits/{kit}/share/{link}', [BrandKitShareController::class, 'revoke'])->name('app.kits.share.revoke');

    Route::get('/workspace/members', [WorkspaceMemberController::class, 'index'])->name('app.workspace.members');
    Route::post('/workspace/invites', [WorkspaceMemberController::class, 'store'])->middleware('throttle:5,1')->name('app.workspace.invites.store');
    Route::put('/workspace/settings', [WorkspaceMemberController::class, 'updateSettings'])->name('app.workspace.settings.update');
    Route::post('/workspace/create', [WorkspaceMemberController::class, 'createWorkspace'])->name('app.workspace.create');

    Route::get('/billing', [BillingController::class, 'index'])->name('app.billing');
    Route::post('/billing/checkout/{plan}', [BillingController::class, 'checkout'])->name('app.billing.checkout');
    Route::post('/billing/portal', [BillingController::class, 'portal'])->name('app.billing.portal');

    Route::get('/settings', [SettingsController::class, 'index'])->name('app.settings');
    Route::put('/settings', [SettingsController::class, 'update'])->name('app.settings.update');
});

Route::get('/invites/{token}', [WorkspaceMemberController::class, 'accept'])->name('invites.accept');
