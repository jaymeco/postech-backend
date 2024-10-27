<?php

namespace Database\Seeders;

use App\Models\Category;
use Core\Domain\Base\Enums\CategoryEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = CategoryEnum::cases();

        collect($categories)->each(function ($item) {
            Category::create([
                Category::UUID => $item->key(),
                Category::NAME => $item->name(),
            ]);
        });
    }
}
