<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate:refresh --path=database/migrations/2025_03_26_145455_create_maintenances_table.php
     */
    public function up(): void
    {
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id');
            $table->foreignId('category_id');
            $table->foreignId('maintenance_mission_id')->nullable();
            $table->foreignId('office');
            $table->foreignId('department_id')->nullable();
            $table->foreignId('location');
            $table->foreignId('end_user');
            $table->date('maintenance_date');
            $table->string('maintenace_by');
            $table->string('device_name')->nullable();
            $table->string('reference')->nullable();
            $table->string('status')->default('pending');
            $table->foreignId('accepted_by')->nullable();
            $table->date('accepted_date')->nullable();
            $table->longText('description')->nullable();
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
        Schema::dropIfExists('maintenances');
    }
};
