<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Mail\MailManager;
use Illuminate\Support\Facades\Log;

class MailTransportServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // DISABLED - RateLimitedSmtpTransport class does not exist
        // Override the mail manager to use our rate-limited transport
        /*
        $this->app->resolving(MailManager::class, function ($mailManager) {
            $mailManager->extend('smtp', function ($config) {
                Log::info('MailTransportServiceProvider: Creating RateLimitedSmtpTransport', [
                    'host' => $config['host'] ?? 'unknown',
                    'port' => $config['port'] ?? 25,
                    'encryption' => $config['encryption'] ?? 'none'
                ]);
                
                // Create SocketStream with proper configuration
                $stream = new SocketStream();
                $stream->setHost($config['host'] ?? 'localhost');
                $stream->setPort($config['port'] ?? 25);
                
                // Handle encryption properly for Mailtrap
                $encryption = $config['encryption'] ?? null;
                if ($encryption === 'tls') {
                    $stream->setEncryption('tls');
                } elseif ($encryption === 'ssl') {
                    $stream->setEncryption('ssl');
                }
                
                return new RateLimitedSmtpTransport($stream);
            });
        });
        */
    }
}
