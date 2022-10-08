<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->float('account_balance')->default(0);
            $table->unsignedBigInteger('plan_id')->default(0);
            $table->integer('expires_in')->default(0);
            $table->string('referral')->nullable();
            $table->integer('code');
            $table->string('phone_number');
            $table->string('photo')->default('images/empty.jpg');
            $table->boolean('has_withdrawn')->default(0);
            $table->boolean('has_clicked_ads')->default(0);
            $table->boolean('is_advert')->default(0);
            $table->boolean('is_blocked')->default(0);
            $table->integer('advert_expires_in')->default(0);
            $table->string('password');
            $table->boolean('is_admin')->default(0);
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