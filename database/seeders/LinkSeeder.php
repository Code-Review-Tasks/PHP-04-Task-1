<?php

namespace Database\Seeders;

use App\Models\Link;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class LinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = mt_rand(20, 100); $i > 0; $i--) {
            
            $data = ['long_url' => $faker->url()];

            if (mt_rand(0, 10) > 3) {
                $data['title'] = ucwords($faker->words(mt_rand(1, 4), true));
            }

            $link = Link::create($data);

            // tags
            $tagNames = $faker->words(mt_rand(0, 5));
            foreach ($tagNames as $tagName) {
                $link->tags()->firstOrCreate(['name' => $tagName]);
            }                
        }
    }
}
