<?php

namespace Database\Factories;

use App\Libs\UrlShortener\UrlShortener;
use App\Models\ShortLink;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShortLinkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     * @throws Exception
     */
    public function definition()
    {
        $url = $this->faker->url();

        return [
            'long_url' => $url,
            'title' => $this->faker->title,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (ShortLink $shortLink) {
            $shortLink->short_url = (new UrlShortener())->encode($shortLink->id, $shortLink->long_url);
            $shortLink->save();
        });
    }
}
