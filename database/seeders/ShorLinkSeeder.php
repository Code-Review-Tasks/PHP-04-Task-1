<?php

namespace Database\Seeders;

use App\Models\ShortLink;
use Illuminate\Database\Seeder;

class ShorLinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ShortLink::factory()
            ->count(10)
            ->create();
    }
}
