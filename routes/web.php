<?php

use App\Livewire\ClientManager;
use App\Livewire\Customer\Auth\Login;
use App\Livewire\Customer\Auth\Register;
use App\Livewire\Dashboard;
use App\Livewire\EquipmentManager;
use App\Livewire\InvoiceManager;
use App\Livewire\NotificationManager;
use App\Livewire\PlanManager;
use App\Livewire\ProductManager;
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

    Route::get('products', ProductManager::class)->name('products');
    Route::get('equipments', EquipmentManager::class)->name('equipments');

    Route::get('subscriptions', SubscriptionManager::class)->name('subscriptions');

    Route::get('invoices', InvoiceManager::class)->name('invoices');

    Route::get('tickets', TicketManager::class)->name('tickets');

    Route::get('reports', ReportGenerator::class)->name('reports');
    
    Route::get('notifications', NotificationManager::class)->name('notifications');
});
Route::prefix('portal')->name('customer.')->group(function () {
    
    /*
    |--------------------------------------------------------------------------
    | Autenticação (Guest)
    |--------------------------------------------------------------------------
    */
    Route::middleware('guest:customer')->group(function () {
        Route::get('/login', Login::class)->name('login');
        Route::get('/register', Register::class)->name('register');
        // Route::get('/forgot-password', ForgotPassword::class)->name('password.request');
        // Route::get('/reset-password/{token}', ResetPassword::class)->name('password.reset');
    });

    /*
    |--------------------------------------------------------------------------
    | Logout (POST)
    |--------------------------------------------------------------------------
    */
    Route::post('/logout', function() {
        Auth::guard('customer')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('customer.login');
    })->name('logout')->middleware('auth:customer');

    /*
    |--------------------------------------------------------------------------
    | Portal (Authenticated)
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth:customer')->group(function () {
        
        // Dashboard
        Route::get('/dashboard', Dashboard::class)->name('dashboard');
/*
        // Subscrições
        Route::get('/subscriptions', SubscriptionsIndex::class)->name('subscriptions.index');
        Route::get('/subscriptions/{id}', SubscriptionsShow::class)->name('subscriptions.show');

        // Faturas
        Route::get('/invoices', InvoicesIndex::class)->name('invoices.index');
        Route::get('/invoices/{id}', InvoicesShow::class)->name('invoices.show');

        // Tickets
        Route::get('/tickets', TicketsIndex::class)->name('tickets.index');
        Route::get('/tickets/create', TicketsCreate::class)->name('tickets.create');
        Route::get('/tickets/{id}', TicketsShow::class)->name('tickets.show');

        // Perfil
        Route::get('/profile', ProfileEdit::class)->name('profile.edit');

        // Planos (para upgrade)
        Route::get('/plans', PlansIndex::class)->name('plans.index');
*/
    });
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});



require __DIR__ . '/auth.php';
