<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRawMaterialPurchaseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raw_material_purchase_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('raw_material_purchase_id');
            $table->unsignedBigInteger('raw_material_id');
            $table->integer('qty')->default(0);
            $table->double('price')->default(0);
            $table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('raw_material_purchase_id')->references('id')->on('raw_material_purchases');
            $table->foreign('raw_material_id')->references('id')->on('raw_materials');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('raw_material_purchase_details');
    }
}
