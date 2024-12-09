<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class UrlController extends Controller
{
    private const HASH_LENGTH = 6;
    
    /**
     * Encode a URL to a shortened URL
     */
    public function encode(Request $request)
    {
        try {
            $validated = $request->validate([
                'url' => 'required|url|max:2048'
            ]);
            
            $originalUrl = $validated['url'];
            $hash = $this->generateUniqueHash();
            
            Cache::put("url.{$hash}", $originalUrl, now()->addDays(30));
            
            return response()->json([
                'short_url' => url("/") . "/{$hash}",
                'original_url' => $originalUrl
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Invalid URL provided',
                'details' => $e->errors()
            ], 422);
        }
    }
    
    /**
     * Decode a shortened URL to its original URL
     */
    public function decode(Request $request)
    {
        try {
            $validated = $request->validate([
                'short_url' => 'required|url|max:255'
            ]);
            
            $shortUrl = $validated['short_url'];
            $hash = basename($shortUrl);
            
            $originalUrl = Cache::get("url.{$hash}");
            
            if (!$originalUrl) {
                return response()->json([
                    'error' => 'Short URL not found'
                ], 404);
            }
            
            return response()->json([
                'original_url' => $originalUrl
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Invalid short URL provided',
                'details' => $e->errors()
            ], 422);
        }
    }
    
    /**
     * Redirect short URL to original URL
     */
    public function redirect($hash)
    {
        $originalUrl = Cache::get("url.{$hash}");
        
        if (!$originalUrl) {
            abort(404);
        }
        
        return redirect()->away($originalUrl);
    }
    
    /**
     * Generate a unique hash for the URL
     */
    private function generateUniqueHash(): string
    {
        do {
            $hash = Str::random(self::HASH_LENGTH);
        } while (Cache::has("url.{$hash}"));
        
        return $hash;
    }
}