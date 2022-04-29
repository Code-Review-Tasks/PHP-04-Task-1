<?php

namespace Tests\Feature;

use App\Models\Link;
use Illuminate\Foundation\Testing\DatabaseTransactions;
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

    public function test_check_visits_with_navigating_by_short_link()
    {
        $long_url = "https://google.com";
        $title = 'Test title '.microtime();

        $response = $this->postJson('/links', compact('long_url', 'title'));
        $hash = $response->json([0]);

        $link = Link::where(['long_url' => $long_url, 'title' => $title])->firstOrFail();

        $response = $this->get("/l/$hash");
        $response->assertStatus(302);

        $response = $this->get("/l/$hash");

        $link->refresh();
        
        $this->assertEquals(2, $link->total_views);
        $this->assertEquals(1, $link->unique_views);
    }
}
