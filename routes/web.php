<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::get('/setup-admin', function () {
    \App\Models\User::updateOrCreate(
        ['email' => 'admin@gmail.com'],
        [
            'name'     => 'Administrator',
            'username' => 'admin',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role'     => 'admin'
        ]
    );
    return 'Akun Admin berhasil dibuat! Silakan login dengan Username: admin dan Password: password';
});

Route::get('/setup-users', function () {
    // Create test users
    \App\Models\User::updateOrCreate(
        ['email' => 'user1@gmail.com'],
        [
            'name'     => 'User Test 1',
            'username' => 'user1',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role'     => 'user'
        ]
    );
    
    \App\Models\User::updateOrCreate(
        ['email' => 'user2@gmail.com'],
        [
            'name'     => 'User Test 2',
            'username' => 'user2',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role'     => 'user'
        ]
    );
    
    return 'Test users created!<br>user1 / password<br>user2 / password<br>admin / password';
});

Route::get('/login-as/{id}', function ($id) {
    // Only allow admin to switch users
    if (!Auth::check() || !Auth::user()->isAdmin()) {
        abort(403, 'Unauthorized');
    }
    
    $user = \App\Models\User::find($id);
    if ($user) {
        \Illuminate\Support\Facades\Auth::login($user);
        return redirect('/dashboard')->with('success', 'Logged in as ' . $user->name);
    }
    return redirect('/dashboard')->with('error', 'User not found');
})->middleware('auth');

// Auth Routes
Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->middleware('guest');
Route::get('/register', [App\Http\Controllers\AuthController::class, 'showRegisterForm'])->name('register')->middleware('guest');
Route::post('/register', [App\Http\Controllers\AuthController::class, 'register'])->middleware('guest');

// Google Auth
Route::get('/auth/google', [App\Http\Controllers\AuthController::class, 'redirectToGoogle'])->name('google.login')->middleware('guest');
Route::get('/auth/google/callback', [App\Http\Controllers\AuthController::class, 'handleGoogleCallback'])->middleware('guest');

// Complete Registration after Google
Route::get('/register/complete', [App\Http\Controllers\AuthController::class, 'showCompleteRegistrationForm'])->name('register.complete')->middleware('guest');
Route::post('/register/complete', [App\Http\Controllers\AuthController::class, 'completeRegistration'])->middleware('guest');

// Password Reset via QR
Route::get('/password/reset', [App\Http\Controllers\AuthController::class, 'showQrResetForm'])->name('password.request')->middleware('guest');
Route::post('/password/reset', [App\Http\Controllers\AuthController::class, 'resetPasswordViaQr'])->name('password.update')->middleware('guest');
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout')->middleware('auth');
Route::get('/logout', function () {
    return redirect('/')->with('error', 'Logout harus menggunakan POST method');
})->middleware('auth');

// Profile Route
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password');
});

// Protected Routes
Route::middleware(['auth'])->group(function () {
    // Books (All authenticated users can see)
    Route::get('/books', [App\Http\Controllers\BookController::class, 'index'])->name('books.index');
    
    // Borrowings (User routes)
    Route::get('/borrowings', [App\Http\Controllers\BorrowingController::class, 'index'])->name('borrowings.index');
    Route::post('/borrowings/{book}', [App\Http\Controllers\BorrowingController::class, 'store'])->name('borrowings.store');


    
    // Notifications (all auth users)
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [App\Http\Controllers\NotificationController::class, 'markRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [App\Http\Controllers\NotificationController::class, 'markAllRead'])->name('notifications.mark-all-read');
    
    // Guides (all auth users)
    Route::get('/guide/user', [App\Http\Controllers\GuideController::class, 'userGuide'])->name('guide.user');

    // QR Code (all auth users)
    Route::get('/qr-code', [App\Http\Controllers\QrCodeController::class, 'show'])->name('qr-code.show');
    Route::post('/qr-code/regenerate', [App\Http\Controllers\QrCodeController::class, 'regenerate'])->name('qr-code.regenerate');
    Route::post('/qr-code/scan', [App\Http\Controllers\QrCodeController::class, 'scan'])->name('qr-code.scan');

    // Library Map (all auth users)
    Route::get('/libraries/map', [App\Http\Controllers\LibraryController::class, 'map'])->name('libraries.map');

    // Messages (all auth users)
    Route::get('/messages', [App\Http\Controllers\MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/create', [App\Http\Controllers\MessageController::class, 'create'])->name('messages.create');
    Route::post('/messages', [App\Http\Controllers\MessageController::class, 'store'])->name('messages.store');
    Route::get('/messages/{message}', [App\Http\Controllers\MessageController::class, 'userShow'])->name('messages.user-show');
    
    // Admin Routes
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/books/create', [App\Http\Controllers\BookController::class, 'create'])->name('books.create');
        Route::post('/books', [App\Http\Controllers\BookController::class, 'store'])->name('books.store');
        Route::get('/books/{book}/edit', [App\Http\Controllers\BookController::class, 'edit'])->name('books.edit');
        Route::put('/books/{book}', [App\Http\Controllers\BookController::class, 'update'])->name('books.update');
        Route::delete('/books/{book}', [App\Http\Controllers\BookController::class, 'destroy'])->name('books.destroy');
        
        // Admin update borrowing status
        Route::put('/borrowings/{borrowing}/return', [App\Http\Controllers\BorrowingController::class, 'markAsReturned'])->name('borrowings.return');


        
        // Admin: Offline borrowing & Print
        Route::get('/borrowings/print', [App\Http\Controllers\BorrowingController::class, 'print'])->name('borrowings.print');
        Route::get('/offline-borrowings/create', [App\Http\Controllers\BorrowingController::class, 'createOffline'])->name('borrowings.create-offline');
        Route::post('/offline-borrowings/store', [App\Http\Controllers\BorrowingController::class, 'storeOffline'])->name('borrowings.store-offline');
        
        // Admin: Data User
        Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}', [App\Http\Controllers\UserController::class, 'show'])->name('users.show');
        Route::delete('/users/{user}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
        
        // Admin: Scanner
        Route::get('/admin/scanner', [App\Http\Controllers\QrCodeController::class, 'scanner'])->name('admin.scanner');
        
        // Admin: Categories
        Route::get('/categories', [App\Http\Controllers\CategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories', [App\Http\Controllers\CategoryController::class, 'store'])->name('categories.store');
        Route::put('/categories/{category}', [App\Http\Controllers\CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [App\Http\Controllers\CategoryController::class, 'destroy'])->name('categories.destroy');

        // Admin: Libraries
        Route::get('/libraries', [App\Http\Controllers\LibraryController::class, 'index'])->name('libraries.index');
        Route::get('/libraries/create', [App\Http\Controllers\LibraryController::class, 'create'])->name('libraries.create');
        Route::post('/libraries', [App\Http\Controllers\LibraryController::class, 'store'])->name('libraries.store');
        Route::get('/libraries/{library}/edit', [App\Http\Controllers\LibraryController::class, 'edit'])->name('libraries.edit');
        Route::put('/libraries/{library}', [App\Http\Controllers\LibraryController::class, 'update'])->name('libraries.update');
        Route::delete('/libraries/{library}', [App\Http\Controllers\LibraryController::class, 'destroy'])->name('libraries.destroy');

        // Admin: Notifications
        Route::get('/notifications/create', [App\Http\Controllers\NotificationController::class, 'create'])->name('notifications.create');
        Route::post('/notifications', [App\Http\Controllers\NotificationController::class, 'store'])->name('notifications.store');
        Route::delete('/notifications/{notification}', [App\Http\Controllers\NotificationController::class, 'destroy'])->name('notifications.destroy');
        
        // Admin: Guides
        Route::get('/guide/admin', [App\Http\Controllers\GuideController::class, 'adminGuide'])->name('guide.admin');
        
        // Admin: Messages
        Route::get('/admin/messages', [App\Http\Controllers\MessageController::class, 'adminIndex'])->name('messages.admin');
        Route::get('/admin/messages/{message}', [App\Http\Controllers\MessageController::class, 'show'])->name('messages.show');
        Route::post('/admin/messages/{message}/reply', [App\Http\Controllers\MessageController::class, 'reply'])->name('messages.reply');
    });
});
