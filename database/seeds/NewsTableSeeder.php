<?php


use Faker\Factory;
use Illuminate\Database\Seeder;
use Lartificer\News\Models\News;

class NewsTableSeeder extends Seeder{

    public function run() {

        $faker = Faker\Factory::create();
        for($i = 0; $i < 100; $i++) {
            $newsEntry = News::create([
                'user_id' => 1,
                'visible' => $faker->boolean(20),
            ]);
        }
    }

}