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
        Schema::create('info_users', function (Blueprint $table) {
            $table->id();
            $table->text('avatar')->nullable();
            $table->string('name')->nullable();
            $table->string('position')->nullable();
            $table->string('identification')->nullable();
            $table->string('tel')->nullable();
            $table->integer('active')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('info_users');
    }
};
