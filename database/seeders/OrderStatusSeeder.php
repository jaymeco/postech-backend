<?php

namespace Database\Seeders;

use App\Models\OrderStatus as Model;
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
            if ($this->checkIfChanged($item->key())) {
                $this->updateIfExists($item->key(), $item->name());
            } else {
                $this->insertIfNotExists($item->key(), $item->name());
            }
        });
    }

    private function checkIfChanged(string $uuid)
    {
        return Model::where(Model::UUID, '=', $uuid)
            ->exists();
    }

    private function insertIfNotExists(string $uuid, string $name)
    {
        Model::create([
            Model::UUID => $uuid,
            Model::NAME => $name,
        ]);
    }

    private function updateIfExists(string $uuid, string $name)
    {
        Model::where(Model::UUID, '=', $uuid)
            ->update([
                Model::NAME => $name
            ]);
    }
}
