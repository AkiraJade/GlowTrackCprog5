<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class EmailRateLimitServiceProvider extends ServiceProvider
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
        // Simple rate limiting to prevent Mailtrap limit errors
        Event::listen(MessageSending::class, function (MessageSending $event) {
            $key = 'last_email_sent_time';
            $minDelay = 30.0; // 30 seconds between emails (very conservative)
            
            $lastSendTime = Cache::get($key);
            
            if ($lastSendTime) {
                $elapsed = microtime(true) - $lastSendTime;
                
                if ($elapsed < $minDelay) {
                    $waitTime = $minDelay - $elapsed;
                    Log::warning('Rate limiting: Waiting ' . round($waitTime, 2) . ' seconds to prevent Mailtrap limit error', [
                        'to' => $event->message->getTo() ? array_keys($event->message->getTo())[0] : 'unknown'
                    ]);
                    
                    // Wait before sending
                    usleep((int)($waitTime * 1000000)); // Convert to microseconds
                    
                    Log::info('Rate limiting: Wait completed, proceeding with email send');
                }
            }
            
            // Update the last send time
            Cache::put($key, microtime(true), 300); // Store for 5 minutes
            
            Log::info('Rate limiting: Email allowed through', [
                'to' => $event->message->getTo() ? array_keys($event->message->getTo())[0] : 'unknown',
                'elapsed_since_last' => round($elapsed ?? 0, 3)
            ]);
        });
    }
}
