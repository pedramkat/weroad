<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('travels', function (Blueprint $table) {
            $table->uuid('id')->primary();
            // In production the default value may be
            $table->boolean('isPublic')->default(true);
            $table->string('slug')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('numberOfDays')->nullable();
            $table->integer('nature')->nullable();
            $table->integer('relax')->nullable();
            $table->integer('history')->nullable();
            $table->integer('culture')->nullable();
            $table->integer('party')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travels');
    }
};
