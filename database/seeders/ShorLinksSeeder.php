<?php

namespace Database\Seeders;

use App\Models\ShortLinks;
use Illuminate\Database\Seeder;

class ShorLinksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ShortLinks::factory()
            ->count(10)
            ->create();
    }
}
