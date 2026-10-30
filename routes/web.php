<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SkillController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — Shahzad Labs
|--------------------------------------------------------------------------
|
| Public pages: Home, Projects, Project Detail, Skills, Services, Contact.
| Admin management: Dashboard, Projects CRUD, Skills CRUD, Messages, Profile.
|
*/

// ── Public Pages & Portfolio ─────────────────────────────────────────
Route::get('/', [PortfolioController::class, 'index'])->name('home');
Route::get('/projects', [PortfolioController::class, 'projects'])->name('projects.index');
Route::get('/projects/{slug}', [PortfolioController::class, 'projectShow'])->name('projects.show');
Route::get('/skills', [PortfolioController::class, 'skills'])->name('skills.index');
Route::get('/services', [PortfolioController::class, 'services'])->name('services.index');
Route::get('/contact', [PortfolioController::class, 'contactPage'])->name('contact.index');
Route::post('/contact', [PortfolioController::class, 'contact'])->name('contact.submit');
Route::get('/sitemap.xml', [PortfolioController::class, 'sitemap'])->name('sitemap');

// ── Storage Asset Fallback ──────────────────────────────────────────
Route::match(['GET', 'HEAD'], '/storage/{path}', function (string $path) {
    $cleanPath = ltrim(preg_replace('#^(public/)?storage/#i', '', $path), '/');

    // 1. Check via public disk
    try {
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($cleanPath)) {
            $filePath = \Illuminate\Support\Facades\Storage::disk('public')->path($cleanPath);
            if (file_exists($filePath) && !is_dir($filePath)) {
                $mime = mime_content_type($filePath) ?: 'application/octet-stream';
                return response()->file($filePath, [
                    'Content-Type' => $mime,
                    'Cache-Control' => 'public, max-age=31536000, immutable',
                ]);
            }
        }
    } catch (\Throwable $e) {}

    // 2. Direct filesystem candidates
    $candidates = [
        storage_path('app/public/' . $cleanPath),
        storage_path('app/public/' . $path),
        public_path('storage/' . $cleanPath),
        base_path('storage/app/public/' . $cleanPath),
        public_path('images/' . $cleanPath),
        public_path($cleanPath),
        '/tmp/storage/app/public/' . $cleanPath,
    ];

    foreach ($candidates as $filePath) {
        if (file_exists($filePath) && !is_dir($filePath)) {
            $mime = mime_content_type($filePath) ?: 'application/octet-stream';
            return response()->file($filePath, [
                'Content-Type' => $mime,
                'Cache-Control' => 'public, max-age=31536000, immutable',
            ]);
        }
    }

    // 3. Fallback: If image not found, serve placeholder image instead of broken 404
    $placeholder = public_path('images/project-placeholder.svg');
    if (file_exists($placeholder)) {
        return response()->file($placeholder, [
            'Content-Type' => 'image/svg+xml',
            'Cache-Control' => 'no-cache, private',
        ]);
    }

    abort(404);
})->where('path', '.*')->name('storage.file');

// ── Admin Dashboard (protected) ──────────────────────────────────────
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard overview
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Projects CRUD
    Route::resource('projects', ProjectController::class);

    // Skills CRUD
    Route::resource('skills', SkillController::class);

    // Messages / Inquiries
    Route::get('/messages', [DashboardController::class, 'messages'])->name('messages');
    Route::get('/messages/{message}', [DashboardController::class, 'showMessage'])->name('messages.show');
    Route::post('/messages/{message}/reply', [DashboardController::class, 'replyMessage'])->name('messages.reply');
    Route::delete('/messages/{message}', [DashboardController::class, 'destroyMessage'])->name('messages.destroy');

    // Site Branding & Settings (Hero Image, Logo, Favicon)
    Route::get('/settings', [\App\Http\Controllers\SettingController::class, 'edit'])->name('settings.edit');
    Route::post('/settings', [\App\Http\Controllers\SettingController::class, 'update'])->name('settings.update');

    // Profile (Admin routes)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Standard Breeze profile route aliases
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Redirect old /dashboard to new admin dashboard
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
