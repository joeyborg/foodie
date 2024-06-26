<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\User;
use App\Models\Venue;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Joey Borg',
            'email' => 'joey@foodie.mt',
        ]);

        // load burgers.json
        $json = file_get_contents(database_path('seeders/burgers.json'));

        // Create venues (get them from sections.items)
        $venues = collect(json_decode($json, true)['sections'])
            ->map(fn ($section) => $section['items'])
            ->flatten(1)
            ->map(function ($item) {
                $venue = $item['venue'];

                return [
                    'wolt_id' => $venue['id'],
                    'name' => $venue['name'],
                    'slug' => $venue['slug'],
                    'short_description' => $venue['short_description'],
                    'address' => $venue['address'],
                    'latitude' => $venue['location'][0],
                    'longitude' => $venue['location'][1],
                    'price_range' => $venue['price_range'],
                    'wolt_rating' => $venue['rating'] ?? null,
                    'tags' => $venue['tags'],
                    'delivers' => $venue['delivers'],
                    //
                    'image_url' => $item['image']['url'],
                ];
            })
            ->unique('slug');

        foreach ($venues as $venue) {
            $tags = $venue['tags'];

            unset($venue['tags']);

            $model = Venue::firstOrCreate([
                'wolt_id' => $venue['wolt_id'],
            ], $venue);

            $model->tags()->detach();

            foreach ($tags as $tag) {
                $model->tags()->attach(
                    Tag::firstOrCreate([
                        'key' => $tag,
                    ], [
                        'name' => $tag,
                    ])->id
                );
            }
        }

        $venue = Venue::where('wolt_id', '645b823db37d14debeaa2278')->first();

        // load 645b823db37d14debeaa2278.json
        $json = file_get_contents(database_path('seeders/645b823db37d14debeaa2278.json'));

        // Create items (get them from items)
        $items = collect(json_decode($json, true)['items'])
            ->map(function ($item) use ($venue) {
                return [
                    'venue_id' => $venue->id,
                    'wolt_id' => $item['id'],
                    'name' => $item['name'],
                    'price' => $item['baseprice'],
                    'original_price' => $item['original_price'] ?? null,
                    'description' => $item['description'],
                    'image_url' => $item['image'] ?? null,
                    'type' => $item['type'],
                ];
            });

        foreach ($items as $item) {
            $model = $venue->items()->firstOrCreate([
                'wolt_id' => $item['wolt_id'],
            ], $item);
        }
    }
}
