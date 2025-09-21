<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;

class FavoriteSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::query()->select('id')->get();
        $productIds = Product::query()->pluck('id');

        if ($users->isEmpty() || $productIds->isEmpty()) {
            $this->command?->error('  Skipping FavoriteSeeder: no users or products found.');
            return;
        }

        foreach ($users as $user) {
            $max = min(8, $productIds->count());
            $count = $max > 0 ? random_int(1, $max) : 0;
            if ($count === 0) {
                continue;
            }

            $ids = $productIds->shuffle()->take($count)->all();

            // Clean and simple: use pivot relation to avoid duplicates
            $user->favoriteProducts()->syncWithoutDetaching($ids);
        }

        $this->command?->info('  Create favorites successfully!');
    }
}

