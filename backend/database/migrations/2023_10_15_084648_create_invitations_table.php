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
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['ACTIVE', 'INACTIVE', 'INCOMPLETE']);
            $table->string('slug')->nullable()->unique();
            $table->boolean('is_custom_domain');
            $table->string('custom_domain')->nullable();

            // Foreign Key
            $table->foreignId('user_id');               $table->foreign('user_id')->references('id')->on('users');
            $table->foreignUuid('order_id');              $table->foreign('order_id')->references('id')->on('orders');
            $table->foreignId('invitation_type_id');    $table->foreign('invitation_type_id')->references('id')->on('invitation_types');

            // $table->integer('created_by')->unsigned()->nullable();
            // $table->integer('updated_by')->unsigned()->nullable();
            // $table->integer('deleted_by')->unsigned()->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};
