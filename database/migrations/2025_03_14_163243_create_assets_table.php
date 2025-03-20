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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id');
            $table->foreignId('office');
            $table->foreignId('location');
            $table->foreignId('end_user')->nullable();
            $table->string('serial')->nullable();
            $table->string('device_name');
            $table->date('date')->nullable();
            $table->foreignId('created_by');
            $table->foreignId('updated_by')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
