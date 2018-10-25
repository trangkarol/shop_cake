<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableOrderDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->string('id', 36)->index()->unique();
            $table->unsignedInteger('number');
            $table->unsignedInteger('cost');
            $table->unsignedInteger('price');
            $table->string('order_id', 36);
            $table->string('cake_id', 36);
            $table->dateTimeTz('date_create');
            $table->string('created_by', 36)->nullable();
            $table->dateTimeTz('created_at')->nullable();
            $table->string('updated_by', 36)->nullable();
            $table->dateTimeTz('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_details');
    }
}
