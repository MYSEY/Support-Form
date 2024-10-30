<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate:refresh --path=database/migrations/2024_07_31_101457_create_ticket_histories_table.php
     */
    public function up(): void
    {
        Schema::create('ticket_histories', function (Blueprint $table) {
            $table->id();
            $table->string('trackid');
            $table->string('type');
            $table->longText('message')->nullable();
            $table->mediumText('message_html')->nullable();
            $table->integer('from_department_id')->nullable();
            $table->integer('to_department_id')->nullable();
            $table->integer('from_branch_id')->nullable();
            $table->integer('to_branch_id')->nullable();
            $table->string('assignedby')->nullable();
            $table->integer('recipient_id')->nullable();
            $table->integer('from_status')->nullable();
            $table->integer('to_status')->nullable();
            $table->integer('from_priority_id')->nullable();
            $table->integer('to_priority_id')->nullable();
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_histories');
    }
};
