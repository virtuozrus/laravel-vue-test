<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id');
            $table->enum('status', ['ok', 'deleted', 'public'])->default('ok');
            $table->string('name', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->text('text')->nullable();
            $table->text('file')->nullable();
            $table->text('image')->nullable();
            $table->tinyInteger('votes')->default(0);
            $table->timestamps();
            $table->index(['user_id']);
            $table->index(['status']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
