<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_result_protokols', function (Blueprint $table) {
            $table->id();
            $table->string('user');
            $table->string('user_id');
            $table->string('district');
            $table->date('birthday');
            $table->string('sex');
            $table->string('name_protokol');
            $table->json('normative');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_result_protokols');
    }
};
