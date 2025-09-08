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
        if (!Schema::hasTable('protokol_names')) {
            Schema::create('protokol_names', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable()->unique();
                $table->string('name_id')->nullable()->unique();
                $table->string('date')->nullable();
                $table->timestamps();
            });
        }

        Schema::table('protokol_names', function (Blueprint $table) {
            if (!Schema::hasColumn('protokol_names', 'date')) {
                $table->string('date')->nullable()->after('name_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('protokol_names');
    }
};
