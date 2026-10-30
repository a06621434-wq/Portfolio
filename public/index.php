<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

$baseDir = dirname(__DIR__);

// 1. Verify Composer autoloader exists
if (!file_exists($baseDir . '/vendor/autoload.php')) {
    http_response_code(500);
    echo '<!DOCTYPE html><html><head><title>Deployment in progress</title><style>body{font-family:sans-serif;padding:2rem;background:#0f172a;color:#f8fafc}</style></head><body>';
    echo '<h1>vendor/autoload.php not found</h1>';
    echo '<p>Hostinger is still installing dependencies or Composer needs to run. Please check Git deployment status in hPanel.</p>';
    echo '</body></html>';
    exit(1);
}

// 2. Auto-create .env from .env.example if missing
$envPath = $baseDir . '/.env';
$envExamplePath = $baseDir . '/.env.example';

if (!file_exists($envPath) && file_exists($envExamplePath)) {
    @copy($envExamplePath, $envPath);
}

// 3. Ensure APP_KEY fallback if not present in environment
if (!getenv('APP_KEY')) {
    $fallbackKey = 'base64:J1b4f1dPBV9pkfrTg+r8agD7a1dmiRSvRt1adO0BR2s=';
    putenv("APP_KEY={$fallbackKey}");
    $_ENV['APP_KEY'] = $fallbackKey;
    $_SERVER['APP_KEY'] = $fallbackKey;
}

// 4. Ensure required writable storage and cache directories exist
$storageDirs = [
    $baseDir . '/storage/framework/views',
    $baseDir . '/storage/framework/cache',
    $baseDir . '/storage/framework/cache/data',
    $baseDir . '/storage/framework/sessions',
    $baseDir . '/storage/logs',
    $baseDir . '/storage/app/public',
    $baseDir . '/bootstrap/cache',
];

foreach ($storageDirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0775, true);
    }
}

// 5. Ensure SQLite database exists and has writable permissions
$dbPath = $baseDir . '/database/database.sqlite';
if (!file_exists($dbPath)) {
    @touch($dbPath);
}
if (function_exists('chmod')) {
    @chmod($baseDir . '/database', 0775);
    @chmod($dbPath, 0664);
}

// 6. Ensure public storage link exists (if symlink is allowed on host)
if (function_exists('symlink') && !file_exists(__DIR__ . '/storage') && file_exists($baseDir . '/storage/app/public')) {
    @symlink($baseDir . '/storage/app/public', __DIR__ . '/storage');
}

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = $baseDir . '/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require $baseDir . '/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
try {
    /** @var Application $app */
    $app = require_once $baseDir . '/bootstrap/app.php';

    // Auto-sync database migrations and admin password (Lodhran@345) on deploy
    $markerFile = $baseDir . '/storage/framework/cache/.bootstrap_v3_done';
    if (!file_exists($markerFile)) {
        try {
            \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
            $adminUser = \App\Models\User::firstOrCreate(
                ['email' => 'info@shahzadlabs.com'],
                ['name' => 'Shahzad Labs Admin']
            );
            $adminUser->password = \Illuminate\Support\Facades\Hash::make('Lodhran@345');
            $adminUser->save();
            @touch($markerFile);
        } catch (\Throwable $ignored) {}
    }

    $app->handleRequest(Request::capture());
} catch (\Throwable $e) {
    http_response_code(500);
    echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Application Error</title><style>body{font-family:system-ui,-apple-system,sans-serif;background:#0f172a;color:#f8fafc;padding:2rem;line-height:1.6}h1{color:#f87171;font-size:1.5rem}pre{background:#1e293b;padding:1rem;border-radius:8px;overflow:auto;font-size:0.875rem}strong{color:#38bdf8}</style></head><body>';
    echo '<h1>Laravel Runtime Error</h1>';
    echo '<p><strong>Message:</strong> ' . htmlspecialchars($e->getMessage()) . '</p>';
    echo '<p><strong>File:</strong> ' . htmlspecialchars($e->getFile()) . ':' . $e->getLine() . '</p>';
    echo '<h3>Stack Trace:</h3>';
    echo '<pre>' . htmlspecialchars($e->getTraceAsString()) . '</pre>';
    echo '</body></html>';
}
