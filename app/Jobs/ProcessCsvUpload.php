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

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    public function handle()
    {
        $csv = Reader::createFromPath(Storage::path($this->filePath), 'r');
        $csv->setHeaderOffset(0);
    
        $records = $csv->getRecords();
        $numRecords = count($csv);
        $uploaded = 0;
    
        Log::info('CSV processing started. Total records: ' . $numRecords);
    
        $products = [];
    
        foreach ($records as $record) {
            $products[] = [
                'title' => $record['title'],
                'slug' => $record['slug'],
                'description' => $record['description'],
                'price' => $record['price'],
                'thumbnail' => $record['thumbnail'],
                'sale_price' => $record['sale_price'],
                'category' => $record['category'],
                'brand' => $record['brand'],
                'upsell_items' => $record['upsell_items'],
                'crosssell_items' => $record['crosssell_items'],
                'stock' => $record['stock'],
                'gallery_images' => $record['gallery_images'],
            ];
    
            $uploaded++;
    
            // Insert products in chunks
            if ($uploaded % 500 == 0 || $uploaded == $numRecords) {
                Products::insert($products);
                Log::info('CSV chunk processed. Uploaded records: ' . $uploaded . ' / ' . $numRecords);
                $products = []; // Reset the products array
            }
        }
    
        Log::info('CSV processing completed');
    
        // Delete the CSV file after processing
        Storage::delete($this->filePath);
    }
    
    
}

