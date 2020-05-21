<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->enum('type', ['Admin', 'Sub Admin']);
            $table->tinyInteger('categories_access');
            $table->tinyInteger('products_access');
            $table->tinyInteger('orders_access');
            $table->tinyInteger('users_access');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn(['type','categories_access','products_access','orders_access','users_access']);
        });
    }
}
