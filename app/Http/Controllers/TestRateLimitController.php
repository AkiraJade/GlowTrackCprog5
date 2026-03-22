<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmail;
use App\Models\User;

class TestRateLimitController extends Controller
{
    public function testMultipleEmails(Request $request)
    {
        $results = [];
        $testStartTime = microtime(true);
        
        // Get a test user or create one
        $user = User::first();
        if (!$user) {
            return 'No users found in database';
        }
        
        for ($i = 1; $i <= 3; $i++) {
            $startTime = microtime(true);
            
            try {
                // Use Laravel's Mail facade directly
                Mail::to('test@example.com')->send(
                    new VerifyEmail($user, 'test-url-' . $i)
                );
                
                $endTime = microtime(true);
                $duration = round(($endTime - $startTime) * 1000, 2); // in milliseconds
                
                $results[] = [
                    'email' => $i,
                    'success' => true,
                    'duration_ms' => $duration,
                    'timestamp' => date('H:i:s.u', $startTime)
                ];
                
            } catch (\Exception $e) {
                $endTime = microtime(true);
                $duration = round(($endTime - $startTime) * 1000, 2);
                
                $results[] = [
                    'email' => $i,
                    'success' => false,
                    'error' => $e->getMessage(),
                    'duration_ms' => $duration,
                    'timestamp' => date('H:i:s.u', $startTime)
                ];
            }
        }
        
        $totalDuration = round((microtime(true) - $testStartTime) * 1000, 2);
        
        return response()->json([
            'test_results' => $results,
            'total_time' => $totalDuration . 'ms'
        ]);
    }
}
