<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
            URL::forceScheme('https');
        } elseif (app()->environment('production')) {
            URL::forceScheme('https');
        }
        View::composer('*', function ($view) {
            $settings = [];
            try {
                if (Schema::hasTable('settings')) {
                    $settings = Setting::all()->pluck('value', 'key')->toArray();
                }
            } catch (\Exception $e) {
                $settings = [];
            }

            $resolveUrl = function ($val, $fallback = null) {
                if (!$val) {
                    return $fallback ?: asset('images/shahzad-ali.png');
                }
                if (str_starts_with($val, 'http://') || str_starts_with($val, 'https://') || str_starts_with($val, 'data:image') || str_starts_with($val, '/')) {
                    return $val;
                }
                if (str_starts_with($val, 'images/')) {
                    return asset($val);
                }
                if (file_exists(public_path('images/' . $val))) {
                    return asset('images/' . $val);
                }
                if (file_exists(public_path($val))) {
                    return asset($val);
                }
                if (str_starts_with($val, 'branding/')) {
                    return asset('images/' . $val);
                }
                return asset('storage/' . $val);
            };

            // Default developer portrait (Shahzad Ali)
            $defaultAvatar = asset('images/shahzad-ali.png');

            $heroImage = $resolveUrl($settings['hero_image'] ?? null, $defaultAvatar);
            $siteLogo  = $resolveUrl($settings['site_logo'] ?? null, $heroImage);
            $favicon   = $resolveUrl($settings['favicon'] ?? null, $siteLogo);

            $view->with('siteSettings', array_merge($settings, [
                'hero_image_url' => $heroImage,
                'site_logo_url'  => $siteLogo,
                'favicon_url'    => $favicon,
                'developer_name' => $settings['developer_name'] ?? 'Shahzad Ali',
                'developer_role' => $settings['developer_role'] ?? 'Senior Full-Stack Web Architect',
                'hero_tagline'   => $settings['hero_tagline'] ?? 'Engineering Scalable Web Applications & Digital Experiences',
            ]));
        });
    }
}
