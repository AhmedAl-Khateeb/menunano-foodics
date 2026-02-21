<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use ZipArchive;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ExportStores extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:stores';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export all stores, categories, and products to a ZIP archive.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting export process...');

        $zipPath = storage_path('app/backup.zip');
        $zip = new ZipArchive;

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
            $this->error("Cannot create ZIP file at $zipPath");
            return 1;
        }

        $storesData = [];
        $users = User::whereNotNull('store_name')->with(['categories.products.sizes', 'settings'])->get();

        $bar = $this->output->createProgressBar($users->count());
        $bar->start();

        foreach ($users as $user) {
            // Fetch all settings as key-value pairs
            $allSettings = $user->settings()->pluck('value', 'key')->toArray();
            
            // Logic: store_name in DB is the slug. Business name comes from settings ('Menu Name' or 'name')
            $slug = $user->store_name;
            $businessName = $allSettings['Menu Name'] ?? $allSettings['name'] ?? $user->store_name;

            $storeData = [
                'remote_id' => $user->id,
                'business_name' => $businessName,
                'slug' => $slug,
                'description' => $allSettings['description'] ?? null,
                'phone' => $user->phone,
                'whatsapp_number' => $allSettings['whatsapp'] ?? null,
                'is_open' => $user->status,
                'settings' => $allSettings, // Export all settings
                'images' => [],
                'categories' => []
            ];

            // Handle Store Images
            $logoPath = $allSettings['logo'] ?? null;
            if ($logoPath && Storage::disk('public')->exists($logoPath)) {
                $zipInternalPath = "images/" . basename($logoPath);
                $zip->addFile(Storage::disk('public')->path($logoPath), $zipInternalPath);
                $storeData['images']['logo'] = $zipInternalPath;
            }
            
            // Handle Cover/Background if exists in settings
            // Just in case there is a cover setting
            // $coverPath = $allSettings['cover'] ?? null; 

            // Categories
            foreach ($user->categories as $category) {
                // Determine Category Image Path
                $catImagePath = null;
                $catZipPath = null;
                
                if ($category->cover) {
                     // Check common paths
                     $possiblePaths = [
                         'categories/' . $category->cover,
                         $category->cover
                     ];
                     
                     foreach ($possiblePaths as $path) {
                         if (Storage::disk('public')->exists($path)) {
                             $catImagePath = $path;
                             break;
                         }
                     }
                }

                if ($catImagePath) {
                    $catZipPath = "images/" . basename($catImagePath);
                    $zip->addFile(Storage::disk('public')->path($catImagePath), $catZipPath);
                }

                $categoryData = [
                    'remote_id' => $category->id,
                    'name' => $category->name,
                    'description' => null, 
                    'order' => 1, 
                    'is_active' => $category->is_active ?? true, 
                    'images' => [],
                    'products' => []
                ];
                
                if ($catZipPath) {
                    $categoryData['images']['cover'] = $catZipPath;
                }

                foreach ($category->products as $product) {
                    // Price Logic: Take default price from first size, fallback to product price
                    $price = $product->price;
                    $firstSize = $product->sizes->first();
                    if ($firstSize) {
                        $price = $firstSize->price;
                    }

                    $productData = [
                        'remote_id' => $product->id,
                        'name' => $product->name,
                        'description' => $product->description,
                        'price' => $price,
                        'is_active' => true,
                        'order' => 1,
                        'images' => []
                    ];

                    if ($product->cover && Storage::disk('public')->exists($product->cover)) {
                        $zipInternalPath = "images/" . basename($product->cover);
                        $zip->addFile(Storage::disk('public')->path($product->cover), $zipInternalPath);
                        $productData['images']['main'] = $zipInternalPath;
                    }

                    $categoryData['products'][] = $productData;
                }

                $storeData['categories'][] = $categoryData;
            }

            $storesData[] = $storeData;
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();

        $finalData = [
            'version' => '1.0',
            'exported_at' => now()->toIso8601String(),
            'stores' => $storesData
        ];

        $zip->addFromString('data.json', json_encode($finalData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        $zip->close();

        $this->info("Export completed! File saved at: $zipPath");

        return 0;
    }
}
