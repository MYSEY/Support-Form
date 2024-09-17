<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate:refresh --path=database/migrations/2024_07_22_082717_create_replies_table.php
     */
    public function up(): void
    {
        Schema::create('replies', function (Blueprint $table) {
            $table->id();
            $table->string('reply_to');
            $table->string('name');
            $table->string('staff_id');
            $table->longText('message')->nullable();
            $table->mediumText('message_html')->nullable();
            $table->dateTime('dt')->nullable();
            $table->mediumText('attachments')->nullable();
            $table->integer('rating')->nullable();
            $table->enum('read', ['0', '1'])->default('0');
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('replies');
    }
};
