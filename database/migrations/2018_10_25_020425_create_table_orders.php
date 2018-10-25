<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->string('id', 36)->index()->unique()->change();
            $table->string('order_code', 15)->unique()->change();
            $table->string('user_id', 36);
            $table->unsignedTinyInteger('status')->default(config('setting.order.status.new'));
            $table->unsignedInteger('total_number');
            $table->unsignedInteger('total_cost');
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
        Schema::dropIfExists('orders');
    }
}
