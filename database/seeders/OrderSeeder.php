<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderProduct;
use Carbon\Carbon;
use Faker\Factory as Faker;

class OrderSeeder extends Seeder
{
    /**
     * Number of fake orders to create.
     * You can change this when calling the seeder or here.
     */
    protected int $ordersCount = 50;

    public function run(): void
    {
        $this->command->info('  Create 50 orders successfully!');

        $faker = Faker::create();

        $usersCount = User::count();
        $products = Product::get();

        if ($usersCount === 0 || $products->isEmpty()) {
            $this->command->error('  No users or products found — please seed users and products first.');
            return;
        }

        DB::beginTransaction();

        try {
            for ($i = 0; $i < $this->ordersCount; $i++) {
                // pick random user
                $user = User::inRandomOrder()->first();

                // choose random number of product per order
                $productCount = $faker->numberBetween(1, 6);

                // pick random distinct products
                $picked = $products->random(min($productCount, $products->count()));

                $total = 0;
                $orderItemsData = [];

                foreach ($picked as $product) {
                    // quantity between 1 and 5
                    $quantity = $faker->numberBetween(1, 5);

                    // price taken from product.price (use sale_price logic if you prefer)
                    $price = (float) $product->sale_price;

                    $lineTotal = round($price * $quantity, 2);
                    $total += $lineTotal;

                    $orderItemsData[] = [
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'price' => $price,
                        'total' => $lineTotal,
                        'created_at' => $createdAt = Carbon::now()->subDays($faker->numberBetween(0, 60))->subMinutes($faker->numberBetween(0, 1440)),
                        'updated_at' => $createdAt,
                    ];

                    // Optionally decrease stock — uncomment if desired
                    $product->decrement('stock', $quantity);
                }

                // random created_at for the order (within last 60 days)
                $orderCreatedAt = Carbon::now()->subDays($faker->numberBetween(0, 60))->subMinutes($faker->numberBetween(0, 1440));

                // possible statuses: pending, paid, cancelled, completed
                $statusWeights = ['pending' => 20, 'paid' => 60, 'completed' => 15, 'cancelled' => 5];
                $status = $this->weightedRandom($statusWeights, $faker);

                $order = Order::create([
                    'user_id' => $user->id,
                    'total' => round($total, 2),
                    'status' => $status,
                    'created_at' => $orderCreatedAt,
                    'updated_at' => $orderCreatedAt,
                ]);

                // insert order items
                foreach ($orderItemsData as $itemData) {
                    $itemData['order_id'] = $order->id;
                    OrderProduct::create($itemData);
                }

                $this->command->info("  Created order #{$order->id} for user_id={$user->id} with {$productCount} products (total: {$order->total})");
            }

            DB::commit();
            $this->command->info("  Order seeding complete. Created {$this->ordersCount} orders.");
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->command->error('  Order seeding failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Helper: return a weighted random key from an associative array of weights.
     * Example: ['pending'=>20, 'paid'=>60, 'completed'=>15, 'cancelled'=>5]
     */
    protected function weightedRandom(array $weights, $faker)
    {
        $pool = [];
        foreach ($weights as $key => $weight) {
            for ($i = 0; $i < max(1, (int) $weight); $i++) {
                $pool[] = $key;
            }
        }
        return $faker->randomElement($pool);
    }
}
