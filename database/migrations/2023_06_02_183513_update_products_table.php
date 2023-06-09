<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop foreign key constraint
            $table->dropForeign('products_brand_ids_foreign');

            // Modify column to use JSON data type
            $table->json('category_ids')->nullable()->change();
            $table->json('brand_ids')->nullable()->change();

            // Re-add foreign key constraint
            $table->foreign('brand_ids')->references('id')->on('brands');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop foreign key constraint
            $table->dropForeign('products_brand_ids_foreign');

            // Modify column to use original data type
            $table->bigInteger('category_ids')->nullable()->change();
            $table->bigInteger('brand_ids')->nullable()->change();

            // Re-add foreign key constraint
            $table->foreign('brand_ids')->references('id')->on('brands');
        });
    }
}
