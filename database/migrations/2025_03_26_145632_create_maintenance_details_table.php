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
        Schema::create('maintenance_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maintenance_id');
            $table->foreignId('task_id');
            $table->longText('note')->nullable();
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
        Schema::dropIfExists('maintenance_details');
    }
};
