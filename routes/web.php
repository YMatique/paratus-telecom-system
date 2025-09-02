<?php

use App\Livewire\ClientManager;
use App\Livewire\Dashboard;
use App\Livewire\InvoiceManager;
use App\Livewire\NotificationManager;
use App\Livewire\PlanManager;
use App\Livewire\ReportGenerator;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\SubscriptionManager;
use App\Livewire\TicketManager;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    Route::get('customers', ClientManager::class)->name('customers');

    Route::get('plans', PlanManager::class)->name('plans');

    Route::get('subscriptions', SubscriptionManager::class)->name('subscriptions');

    Route::get('invoices', InvoiceManager::class)->name('invoices');

    Route::get('tickets', TicketManager::class)->name('tickets');

    Route::get('reports', ReportGenerator::class)->name('reports');
    
    Route::get('notifications', NotificationManager::class)->name('notifications');
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__ . '/auth.php';
