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
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->enum('status', ['PAID', 'UNPAID']);

            // Foreign Key
            $table->foreignId('user_id');       $table->foreign('user_id')->references('id')->on('users');
            $table->foreignId('package_id');    $table->foreign('package_id')->references('id')->on('packages');
            $table->foreignId('theme_id');      $table->foreign('theme_id')->references('id')->on('themes');

            // Default
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->integer('deleted_by')->unsigned()->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
