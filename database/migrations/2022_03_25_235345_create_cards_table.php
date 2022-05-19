<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->string('title');
            $table->string('text');
            $table->foreignId('scene_id')->constrained('scenes')->cascadeOnDelete();

            $table->string('category_id');
            $table->string('user_id');

            $table->string('image', 100)->nullable();

            $table->string('url',)->unique();

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
        Schema::dropIfExists('cards');
    }
};
