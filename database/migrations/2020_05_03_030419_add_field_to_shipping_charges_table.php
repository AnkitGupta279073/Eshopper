<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldToShippingChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shipping_charges', function (Blueprint $table) {
            $table->integer('shipping_charges0_500g')->default(0);
            $table->integer('shipping_charges501_1000g')->default(0);
             $table->integer('shipping_charges1001_2000g')->default(0);
              $table->integer('shipping_charges2001_5000g')->default(0);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shipping_charges', function (Blueprint $table) {
            $table->integer(['shipping_charges0_500g','shipping_charges501_1000g','shipping_charges1001_2000g','shipping_charges2001_5000g']);
        });
    }
}
