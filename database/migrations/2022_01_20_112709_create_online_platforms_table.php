<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnlinePlatformsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online_platforms', function (Blueprint $table) {
            $table->id();
            $table->integer('shopify')->nullable();
            $table->integer('facebook')->nullable();
            $table->integer('instagram')->nullable();
            $table->integer('po_for_individual')->nullable();
            $table->integer('po_for_supplier')->nullable();
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
        Schema::dropIfExists('online_platforms');
    }
}
