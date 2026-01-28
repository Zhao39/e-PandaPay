<?php

namespace App\Services;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;

class Website
{
    public function __construct() {}

    public static function url(bool $includeConnection = false): string
    {
        $host = request()->getHost();

        if ($includeConnection) {
            if (self::hasHttps()) {
                $link = 'https';
            } else {
                $link = 'http';
            }
            return "{$link}://{$host}";
        }
        return $host;
    }

    public static function hasHttps(): bool
    {
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            return true;
        }

        return false;
    }

    public static function isSubFolder(string $directory): bool
    {
        $root = $_SERVER['DOCUMENT_ROOT'];
        if ($root === $directory) {
            return false; // installed in the root
        }
        return true;  // installed in a subfolder or subdomain
    }

    public function clearCache(string $type): bool
    {
        $isProduction = App::environment('production');

        if ($type === 'route') {
            Artisan::call('route:clear');
            if ($isProduction) {
                // Artisan::call('route:cache');
                // Artisan::call('route:cache');
            }
        }

        if ($type === 'views') {
            Artisan::call('view:clear');
            if ($isProduction) {
                Artisan::call('view:cache');
            }
        }

        if ($type === 'config') {
            Artisan::call('config:clear');
            if ($isProduction) {
                // Artisan::call('config:cache');
                // Artisan::call('config:cache');
            }
        }

        if ($type === 'logs') {
            Artisan::call('log:clear');
        }

        if ($type === 'symlink') {
            Artisan::call('storage:link');
        }

        if ($type === 'cache') {
            Artisan::call('cache:clear');
        }
        return true;
    }

    public function setToProductionEnvironment()
    {
        $this->clearCache('views');
        $this->clearCache('config');
        $this->clearCache('route');
        $this->clearCache('views');
        $this->clearCache('config');
        $this->clearCache('route');
    }

    public function setToLocalEnvironment()
    {
        Artisan::call('optimize:clear');
        Artisan::call('optimize:clear');
    }
}