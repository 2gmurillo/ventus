<?php

use App\Models\Product;
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
            $table->string('name', 80);
            $table->string('photo')->nullable()->default(null);
            $table->unsignedDecimal('price', $precision = 8, $scale = 2);
            $table->foreignId('category_id')->constrained('categories')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedInteger('stock');
            $table->enum('status', Product::STATUSES)
                ->default(Product::STATUSES['available']);
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
