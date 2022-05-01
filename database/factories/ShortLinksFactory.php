<?php

namespace Database\Factories;

use App\Libs\UrlShortener\UrlShortener;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShortLinksFactory extends Factory
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
            'short_url' => (new UrlShortener())->encode($url),
            'title' => $this->faker->title,
        ];
    }
}
