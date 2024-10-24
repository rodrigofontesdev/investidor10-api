<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $marketsCategory = DB::table('categories')->insertGetId([
            'title' => 'Mercados',
            'slug' => 'mercados',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $internacionalCategory = DB::table('categories')->insertGetId([
            'title' => 'Internacional',
            'slug' => 'internacional',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $politicsCategory = DB::table('categories')->insertGetId([
            'title' => 'Política',
            'slug' => 'politica',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $economyCategory = DB::table('categories')->insertGetId([
            'title' => 'Economia',
            'slug' => 'economia',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        News::factory()->count(24)->create([
            'category' => $marketsCategory,
        ]);

        News::factory()->count(24)->create([
            'category' => $internacionalCategory,
        ]);

        News::factory()->count(24)->create([
            'category' => $politicsCategory,
        ]);

        News::factory()->count(24)->create([
            'category' => $economyCategory,
        ]);
    }
}
