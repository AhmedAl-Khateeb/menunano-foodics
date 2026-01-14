<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderProductSize;
use App\Models\ProductSize;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = ['أحمد علي', 'سارة محمد', 'محمود حسن', 'ليلى سمير', 'خالد يوسف'];
        $phones = ['0100000001', '0100000002', '0100000003', '0100000004', '0100000005'];
        $addresses = ['القاهرة', 'الإسكندرية', 'الجيزة', 'أسيوط', 'المنصورة'];

        $allProductSizes = ProductSize::all();

        foreach (range(0, 4) as $i) {
            $order = Order::create([
                'name' => $names[$i],
                'phone' => $phones[$i],
                'address' => $addresses[$i],
                'total_price' => 0, // نحسبه لاحقاً
                'status' => 'pending',
            ]);

            $selectedSizes = $allProductSizes->random(3); // نختار ٣ أحجام عشوائية (منتجات)

            $totalPrice = 0;

            foreach ($selectedSizes as $size) {
                $quantity = rand(1, 3);
                OrderProductSize::create([
                    'order_id' => $order->id,
                    'product_size_id' => $size->id,
                    'price' => $size->price,
                    'quantity' => $quantity,
                ]);

                $totalPrice += $size->price * $quantity;
            }

            $order->update([
                'total_price' => $totalPrice,
            ]);
        }
    }
}
