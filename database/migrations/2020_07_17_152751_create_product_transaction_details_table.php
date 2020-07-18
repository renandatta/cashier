<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTransactionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_transaction_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_transaction_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('qty')->default(0);
            $table->double('price')->default(0);
            $table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('product_transaction_id')->references('id')->on('product_transactions');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_transaction_details');
    }
}
