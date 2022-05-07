<?php

namespace Tests\Feature;

use App\Models\ShortLink;
use Illuminate\Testing\Fluent\AssertableJson;
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
            ->assertJson(fn (AssertableJson $json) =>
                $json->hasAny('0.long_url', 'https://google.com')
                    ->hasAny('0.title', 'Cool link to google')
            );
    }

    public function test_patch(): void
    {
        $shortLink = ShortLink::first();
        $response = $this->patchJson('/api/links/' . $shortLink->short_url, [
            'long_url' => 'https://google.com',
            'title' => 'New link to google',
            'tags' => ['homepage', 'mylinkNew'],
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'long_url' => 'https://google.com',
                'title' => 'New link to google',
            ]);
    }

    public function test_get(): void
    {
        $shortLink = ShortLink::first();
        $response = $this->get('/api/links/' . $shortLink->short_url);

        $response->assertStatus(200)
            ->assertJson([
                'id' => $shortLink->id,
                'long_url' => $shortLink->long_url,
            ]);
    }

    public function test_delete(): void
    {
        $shortLink = ShortLink::first();
        $response = $this->delete('/api/links/' . $shortLink->short_url);

        $response->assertStatus(200)
            ->assertJson([
                'success' => 'ok',
            ]);

        $shortLink = ShortLink::query()->where('id', $shortLink->id)->get();
        $this->assertEmpty($shortLink);
    }

    /**
     * @throws \JsonException
     */
    public function test_get_list(): void
    {
        $response = $this->get('/api/links');

        $responseData = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $this->assertNotEmpty($responseData);

        $response->assertStatus(200);
    }
}
