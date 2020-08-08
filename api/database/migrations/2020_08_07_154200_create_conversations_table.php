<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConversationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->bigIncrements('id');

            // User 
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            // Contact
            $table->unsignedBigInteger('contact_id');
            $table->foreign('contact_id')->references('id')->on('users');

            // Last messages: content, datetime
            $table->text('last_message')->nullable();
            $table->dateTime('last_time')->nullable();

            $table->boolean('listen_notifications')->default(true);
            $table->boolean('has_blocked')->default(true);

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
        Schema::dropIfExists('conversations');
    }
}
