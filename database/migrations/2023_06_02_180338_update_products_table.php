<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // public function up()
    // {
    //     Schema::table('products', function (Blueprint $table) {
    //         // Add category_ids column
    //         $table->foreignId('category_ids')->nullable()->after('brand')->constrained('categories');

    //         // Add brand_ids column
    //         $table->foreignId('brand_ids')->nullable()->after('category_ids')->constrained('brands');

    //         // Move the upsell_items column after brand_ids
    //         // $table->string('upsell_items')->nullable()->after('brand_ids');
    //     });
    // }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop category_ids column
            // $table->dropForeign(['category_ids']);
            $table->dropColumn('category');
            $table->dropColumn('brand');
        });
    }
};
