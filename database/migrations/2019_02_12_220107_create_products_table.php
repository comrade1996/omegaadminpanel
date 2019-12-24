<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->engine = "InnoDB";
            $table->BigIncrements('id');
            $table->unsignedInteger('unit_id');
            $table->unsignedInteger('category_id');
            $table->string('name');
            $table->float('purchaseprice');
            $table->float('sellingprice');
            $table->mediumInteger('quantity');
            $table->string('company')->nullable();
            $table->date('edate');
            $table->string('photo')->default('profile.png')->nullable();
            $table->string('created_by');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('unit_id')->references('id')->on('units');
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
