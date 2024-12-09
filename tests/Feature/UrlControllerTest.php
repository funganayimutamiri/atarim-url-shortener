<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Cache;

class UrlControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
    }

    public function test_can_encode_valid_url()
    {
        $response = $this->postJson('/api/encode', [
            'url' => 'https://www.thisisalongdomain.com/with/some/parameters?and=here_too'
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'short_url',
                'original_url'
            ]);

        $this->assertEquals(
            'https://www.thisisalongdomain.com/with/some/parameters?and=here_too',
            $response->json('original_url')
        );
    }

    public function test_cannot_encode_invalid_url()
    {
        $response = $this->postJson('/api/encode', [
            'url' => 'not-a-valid-url'
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'error',
                'details'
            ]);
    }

    public function test_can_decode_valid_short_url()
    {
        // First, create a short URL
        $encodeResponse = $this->postJson('/api/encode', [
            'url' => 'https://www.example.com'
        ]);

        $shortUrl = $encodeResponse->json('short_url');

        // Then try to decode it
        $decodeResponse = $this->postJson('/api/decode', [
            'short_url' => $shortUrl
        ]);

        $decodeResponse->assertStatus(200)
            ->assertJson([
                'original_url' => 'https://www.example.com'
            ]);
    }

    public function test_cannot_decode_nonexistent_url()
    {
        $response = $this->postJson('/api/decode', [
            'short_url' => url('/') . '/abc123'
        ]);

        $response->assertStatus(404)
            ->assertJson([
                'error' => 'Short URL not found'
            ]);
    }
}