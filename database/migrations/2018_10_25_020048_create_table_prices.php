<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePrices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->string('id', 36)->index()->unique()->change();
            $table->unsignedInteger('price');
            $table->dateTimeTz('start_date');
            $table->dateTimeTz('end_date');
            $table->boolean('is_show')->default(config('setting.price.is_show.disable'));
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
        Schema::dropIfExists('prices');
    }
}
