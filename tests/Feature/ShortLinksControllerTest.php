<?php

namespace Tests\Feature;

use App\Models\ShortLinks;
use Tests\TestCase;

class ShortLinksControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_store()
    {
        $response = $this->postJson('/api/links', [
            [
                'long_url' => 'https://google.com',
                'title' => 'Cool link to google',
                'tags' => ['homepage', 'mylink'],
            ],
            [
                'long_url' => 'https://yandex.com',
                'title' => 'Cool link to yandex',
                'tags' => ['homepage', 'otherLink'],
            ],
            [
                'long_url' => 'https://laravel.com',
                'title' => 'Cool link to laravel',
                'tags' => ['laravel'],
            ],
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'success' => 'ok',
            ]);
    }

    /** @depends test_store */
    public function test_patch(): void
    {
        $shortLink = ShortLinks::first();
        $response = $this->patchJson('/api/links/' . $shortLink->id, [
            'long_url' => 'https://google.com',
            'title' => 'New link to google',
            'tags' => ['homepage', 'mylinkNew'],
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => 'ok',
            ]);
    }

    /** @depends test_patch */
    public function test_get(): void
    {
        $shortLink = ShortLinks::first();
        $response = $this->get('/api/links/' . $shortLink->id);

        $response->assertStatus(200)
            ->assertJson([
                'id' => $shortLink->id,
                'long_url' => $shortLink->long_url,
            ]);
    }

    /** @depends test_patch */
    public function test_delete(): void
    {
        $shortLink = ShortLinks::first();
        $response = $this->delete('/api/links/' . $shortLink->id);

        $response->assertStatus(200)
            ->assertJson([
                'success' => 'ok',
            ]);
    }

    /** @depends test_patch */
    public function test_get_list(): void
    {
        $response = $this->get('/api/links');

        $responseData = json_decode($response->getContent(), true);
        $this->assertNotEmpty($responseData);

        $response->assertStatus(200);
    }
}
