<?php


use Faker\Factory;
use Illuminate\Database\Seeder;
use Lartificer\News\Models\NewsTranslation;

class NewsTranslationsTableSeeder extends Seeder {

    public function run() {

        $faker = Faker\Factory::create();
        for($i = 0; $i < 100; $i++) {

            $languages = [
                0 => 'en',
                1 => 'de',
                2 => 'fa'
            ];

            foreach($languages as $index => $language) {

                $title = $faker->sentence(5);

                NewsTranslation::create([
                    'title' => $title,
                    'content' => $faker->text(500),
                    'slug' => str_slug($title),
                    'news_id' => ($i + 1),
                    'language' => $language
                ]);

            }

        }
    }
}