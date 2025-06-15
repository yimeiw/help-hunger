<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log; // Add this line if Log is not already imported

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/check-email-role', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'role' => 'required|in:volunteer,donatur'
    ]);

    $user = App\Models\User::where('email', $request->email)->first();

    if (!$user) {
        return response()->json([
            'valid' => false,
            'message' => 'Email not registered.'
        ]);
    }

    if ($user->role !== $request->role) {
        return response()->json([
            'valid' => false,
            'message' => 'This email is registered as '.ucfirst($user->role)
        ]);
    }

    return response()->json(['valid' => true]);
});


// IMPORTANT: Removed the '/api' prefix from the route path
Route::get('/geocode/reverse', function (Request $request) {
    $lat = $request->query('lat');
    $lon = $request->query('lon');

    if (!$lat || !$lon) {
        return response()->json(['error' => 'Latitude and Longitude are required.'], 400);
    }

    try {
        $response = Http::withHeaders([
            'User-Agent' => config('app.name') . ' Laravel Geocoding Proxy/1.0',
            'Referer' => url('/')
        ])->get("https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat={$lat}&lon={$lon}");

        if ($response->successful()) {
            return response()->json($response->json());
        } else {
            Log::error('Nominatim reverse geocoding failed', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            return response()->json(['error' => 'Failed to retrieve address from geocoding service.'], $response->status());
        }
    } catch (\Exception $e) {
        Log::error('Geocoding proxy request failed: ' . $e->getMessage());
        return response()->json(['error' => 'An internal server error occurred during geocoding.'], 500);
    }
})->name('api.geocode.reverse'); // Keep the name as 'api.geocode.reverse' for consistency in JS