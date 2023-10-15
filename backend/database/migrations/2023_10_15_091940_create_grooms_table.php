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
        Schema::create('grooms', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable();
            $table->string('father')->nullable();
            $table->string('mother')->nullable();
            $table->text('address')->nullable();
            $table->string('instagram')->nullable();
            $table->string('image')->nullable()->default('https://source.unsplash.com/X657fvd3smo');

            // Foreign Key
            $table->foreignId('wedding_id')->unique();   $table->foreign('wedding_id')->references('id')->on('weddings');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grooms');
    }
};
