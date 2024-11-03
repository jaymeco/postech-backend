<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Core\Domain\Base\Enums\OrderStatusEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $status = OrderStatusEnum::cases();

        collect($status)->each(function ($item) {
            OrderStatus::create([
                OrderStatus::UUID => $item->key(),
                OrderStatus::NAME => $item->name(),
            ]);
        });
    }
}
