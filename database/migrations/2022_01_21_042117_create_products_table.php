<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id")->nullable();
            $table->integer("supplier_id")->nullable();
            $table->string("barcode")->nullable();
            $table->string("name")->nullable();
            $table->string("sku")->nullable();
            $table->text("description")->nullable();
            $table->integer("quantity")->nullable();
            $table->string("supplier_name")->nullable();
            $table->double("cost_of_good",15,2)->nullable();
            $table->double("retail_price",15,2)->nullable();
            $table->date("expected_date")->nullable();
            $table->date("received_date")->nullable();
            $table->date("delivery_date")->nullable();
            $table->string("product_type")->nullable();
            $table->string("category_id")->nullable();
            $table->string("attribute_id")->nullable();
            $table->integer("shopify_sync")->default(0);
            $table->enum('status', ['Pending', 'Approve', 'Reject'])->default('Pending');
            $table->enum('product_status', ['Draft', 'Publish'])->default('Draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
