<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    /**
     * Get a setting by key with optional fallback.
     */
    public static function get(string $key, ?string $default = null): ?string
    {
        $setting = static::where('key', $key)->first();

        return ($setting && !empty($setting->value)) ? $setting->value : $default;
    }

    /**
     * Set a setting by key.
     */
    public static function set(string $key, ?string $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    /**
     * Get setting value as a fully resolved public URL (for images/files).
     */
    public static function url(string $key, ?string $default = null): string
    {
        $val = static::get($key, $default);

        if (!$val) {
            return $default ?? '';
        }

        if (str_starts_with($val, 'http://') || str_starts_with($val, 'https://') || str_starts_with($val, '/')) {
            return $val;
        }

        return asset('storage/' . $val);
    }
}
