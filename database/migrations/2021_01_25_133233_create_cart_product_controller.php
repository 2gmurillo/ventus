<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartProductController extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_product_controller', function (Blueprint $table) {
            $table->foreignId('product_id')->constrained('products')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('cart_id')->constrained('carts')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedInteger('quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart_product_controller');
    }
}
