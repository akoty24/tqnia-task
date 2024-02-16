<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Client\RequestException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FetchRandomUser implements ShouldQueue

{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

        public function handle()
        {
            // Make HTTP request to the endpoint
            $response = Http::get('https://randomuser.me/api/');
    
            // Check if the request was successful
            if ($response->successful()) {
                // Get the results object from the response
                $results = $response->json('results');
    
                // Log the results object
                Log::info('Random user data retrieved:', $results);
            } else {
                // Log an error if the request failed
                Log::error('Failed to retrieve random user data. HTTP status: ' . $response->status());
            }
        }
        
        // try {
        //     $response = Http::get('https://randomuser.me/api/');
        //     $responseData = $response->json();

        //     if (isset($responseData['results'])) {
        //         Log::info('Random user data:', $responseData['results']);
        //     } else {
        //         Log::warning('No results found in the response from the Random User API.');
        //     }
        // } catch (RequestException $e) {
        //     Log::error('Error fetching random user data: ' . $e->getMessage());
        // }
    }

    
