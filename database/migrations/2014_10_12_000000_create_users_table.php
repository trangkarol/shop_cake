<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('id', 36)->index()->unique()->change();
            $table->string('email')->unique();
            $table->string('nickname');
            $table->string('full_name')->nullable();
            $table->dateTimeTz('birthday');
            $table->string('password');
            $table->unsignedTinyInteger('role')->default(config('user.role.member'));
            $table->unsignedTinyInteger('status')->default(config('user.status.inactive'));
            $table->string('phone_number')->nullable();
            $table->string('address')->nullable();
            $table->string('avatar')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
