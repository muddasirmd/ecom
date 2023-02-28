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
            $table->unsignedBigInteger('section_id')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->string('product_name');
            $table->string('product_code')->nullable();
            $table->string('product_color')->nullable();
            $table->float('product_price')->nullable();
            $table->float('product_discount')->nullable();
            $table->string('product_weight')->nullable();
            $table->string('product_video')->nullable();
            $table->string('product_image')->nullable();
            $table->text('description')->nullable();
            $table->string('wash_care')->nullable();
            $table->string('fabric')->nullable();
            $table->string('pattern')->nullable();
            $table->string('sleeve')->nullable();
            $table->string('fit')->nullable();
            $table->string('occasion')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->enum('is_featured', ['No', 'Yes']);
            $table->tinyInteger('status')->default(0);
            $table->timestamps();

            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
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
