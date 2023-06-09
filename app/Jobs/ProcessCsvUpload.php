<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Products;
use League\Csv\Reader;


class ProcessCsvUpload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;
    protected $start;
    protected $end;

    public function __construct($filePath, $start, $end)
    {
        $this->filePath = $filePath;
        $this->start = $start;
        $this->end = $end;
    }

    public function handle()
    {
        Log::info('ProcessCsvUpload job started.');

        $filePath = str_replace('/', DIRECTORY_SEPARATOR, $this->filePath); // replace forward slash with backslash
        $filePath = str_replace('\\', DIRECTORY_SEPARATOR, $filePath); // replace double backslash with backslash

        if (!Storage::exists($filePath)) {
            Log::error('CSV file does not exist at path: ' . $filePath);
            return;
        }

        $file = new \SplFileObject(Storage::path($filePath), 'r');
        $file->seek($this->start);

        $stream = fopen($file->getRealPath(), 'r');
        $csv = Reader::createFromStream($stream);
        $csv->setHeaderOffset(0);

        $products = [];

        foreach ($csv as $record) {
            $description = !empty($record['description']) ? $record['description'] : null;
            $thumbnail = !empty($record['thumbnail']) ? $record['thumbnail'] : null;
            $price = !empty($record['price']) ? $record['price'] : null;
            $salePrice = !empty($record['sale_price']) ? $record['sale_price'] : null;
            $categoryIds = !empty($record['category_ids']) ? $record['category_ids'] : null;
            $brandIds = !empty($record['brand_ids']) ? $record['brand_ids'] : null;
            $upsellItems = !empty($record['upsell_items']) ? $record['upsell_items'] : null;
            $crosssellItems = !empty($record['crosssell_items']) ? $record['crosssell_items'] : null;
            $stock = !empty($record['stock']) ? $record['stock'] : null;
            $galleryImages = !empty($record['gallery_images']) ? $record['gallery_images'] : null;
        
            $products[] = [
                'title' => $record['title'],
                'slug' => $record['slug'],
                'description' => $description,
                'price' => $price,
                'thumbnail' => $thumbnail,
                'sale_price' => $salePrice,
                'category_ids' => $categoryIds,
                'brand_ids' => $brandIds,
                'upsell_items' => $upsellItems,
                'crosssell_items' => $crosssellItems,
                'stock' => $stock,
                'gallery_images' => $galleryImages,
            ];

            
            if (count($products) % 100 == 0) {
                Products::insert($products);

                
                Log::info('Inserted ' . count($products) . ' records.');

                $products = []; 
            }

            // Stop processing the CSV file after reaching the end line number
            if ($file->key() >= $this->end) {
                break;
            }
        }

        // Insert the remaining products
        if (count($products) > 0) {
            Products::insert($products);
        }

        // Delete the CSV file after processing
        Storage::delete($this->filePath);
        Log::info('ProcessCsvUpload job finished.');
    }
}