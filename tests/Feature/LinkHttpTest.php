<?php

namespace Tests\Feature;

use App\Jobs\RecalculateVisits;
use App\Models\Link;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class LinkHttpTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * Test link creation
     *
     * @return void
     */
    public function test_create_link()
    {
        $long_url = "https://google.com";
        $tags = ['one', 'two'];
        $title = 'Test title '.microtime();

        $response = $this->postJson('/links', compact('long_url', 'tags', 'title'));
        $response->assertStatus(200);
        $response->assertJsonStructure([0]);

        $link = Link::where(['long_url' => $long_url, 'title' => $title])->first();
        $this->assertInstanceOf(Link::class, $link);

        $hash = $response->json(0);
        $this->assertEquals($hash, $link->hash);

        $this->assertEquals(2, $link->tags()->whereIn('name', ['one', 'two'])->count());
    }

    public function test_delete_link()
    {
        $long_url = "https://google.com";
        $title = 'Test title '.microtime();

        $response = $this->postJson('/links', compact('long_url','title'));
        $hash = $response->json(0);
        $this->assertDatabaseHas('links', ['title' => $title]);

        $response = $this->delete("/links/$hash");
        $response->assertStatus(200);
        $this->assertDatabaseMissing('links', ['title' => $title]);
    }

    public function test_patch_link()
    {
        $long_url = "https://google.com";
        $tags = ['one', 'two'];
        $title = 'Test title '.microtime();

        $response = $this->postJson('/links', compact('long_url', 'tags', 'title'));
        $hash = $response->json(0);

        $long_url = "https://microsoft.com";
        $tags = ['three', 'four'];
        $title = 'Test title '.microtime();

        $response = $this->patchJson("/links/$hash", compact('long_url', 'tags', 'title'));
        $response = $this->getJson("/links/$hash");
        $response->assertStatus(200);
        $response->assertJson([
            'hash' => $hash,
            'long_url' => $long_url,
            'tags' => [
                ['name' => 'three'],
                ['name' => 'four']
            ],
            'title' => $title
        ]);
    }

    public function test_get_link()
    {
        $long_url = "https://google.com";
        $tags = ['one', 'two'];
        $title = 'Test title '.microtime();

        $response = $this->postJson('/links', compact('long_url', 'tags', 'title'));
        $hash = $response->json(0);

        $response = $this->getJson("/links/$hash");
        $response->assertStatus(200);
        $response->assertJson([
            'hash' => $hash,
            'long_url' => $long_url,
            'tags' => [
                ['name' => 'one'],
                ['name' => 'two']
            ],
            'title' => $title,
            'total_views' => 0,
            'unique_views' => 0
        ]);
    }

    public function test_get_links()
    {
        $response = $this->getJson('/links');
        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) => $json->hasAll(['data', 'links', 'meta']));
    }

    public function test_get_stats()
    {
        $long_url = "https://google.com";
        $title = 'Test title '.microtime();
        $response = $this->postJson('/links', compact('long_url', 'title'));

        $response = $this->getJson("/stats");

        $response->assertJson(fn (AssertableJson $json) => $json->hasAll(['0.hash', '0.title', '0.total_views', '0.unique_views']));
    }

    public function test_check_visits_with_navigating_by_short_link()
    {
        $long_url = "https://google.com";
        $title = 'Test title '.microtime();

        $response = $this->postJson('/links', compact('long_url', 'title'));
        $hash = $response->json([0]);

        Queue::fake();

        $response = $this->getJson("/l/$hash");
        $response->assertStatus(302);

        $response = $this->getJson("/l/$hash");

        Queue::assertPushed(RecalculateVisits::class, 2);
    }
}
