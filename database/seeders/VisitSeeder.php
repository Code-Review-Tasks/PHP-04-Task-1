<?php

namespace Database\Seeders;

use App\Models\Link;
use Faker\Generator as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VisitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $linkIds = Link::pluck('id');        

        foreach($linkIds as $linkId) {
            $uaMd5Ips = []; // ['md5'.'ip', ...]
            $ip = $faker->ipv4();
            for ($i = mt_rand(0, 120); $i > 0 ; $i--) {
                $uaMd5 = md5(mt_rand(0, 40));
                DB::table('visits')->insert([
                    'link_id' => $linkId,
                    'created_at' => $faker->dateTimeBetween('-3 months')->format('Y-m-d H:i:s'),
                    'ip' => $ip,
                    'user_agent_hash' => $uaMd5
                ]);

                $uaMd5Ips[] = $uaMd5.$ip;

                if (mt_rand(0, 5) > 2) {
                    $ip = $faker->ipv4();
                }
            }

            DB::table('links')->where('id', $linkId)->update([
                'total_views' => count($uaMd5Ips),
                'unique_views' => count(array_unique($uaMd5Ips))
            ]);
        }
        


    }
}
