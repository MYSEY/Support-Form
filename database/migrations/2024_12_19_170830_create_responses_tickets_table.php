<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate:refresh --path=database/migrations/2024_12_19_170830_create_responses_tickets_table.php
     */
    public function up(): void
    {
        Schema::create('responses_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->mediumtext('message');
            $table->string('department_id')->nullable();
            $table->string('branch_id')->nullable();
            $table->string('tpl_order')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('responses_tickets');
    }
};
