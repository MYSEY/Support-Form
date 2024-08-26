<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *  php artisan migrate:refresh --path=database/migrations/2024_08_07_094419_create_permission_categories_table.php
     */
    public function up(): void
    {
        Schema::create('permission_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permission_categories');
    }
};
