<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate:refresh --path=database/migrations/2025_08_22_083541_create_classification_issues_table.php
     */
    public function up(): void
    {
        Schema::create('classification_issues', function (Blueprint $table) {
            $table->id();
            $table->string('department_id');
            $table->string('branch_id');
            $table->string('name');
            $table->string('color');
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
        Schema::dropIfExists('classification_issues');
    }
};
