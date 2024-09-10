<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate:refresh --path=database/migrations/2024_09_05_085118_create_ticket_guidelines_table.php
     */
    public function up(): void
    {
        Schema::create('ticket_guidelines', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->mediumtext('remark')->nullable();
            $table->string('department_id')->nullable();
            $table->string('branch_id')->nullable();
            $table->mediumText('attachments')->nullable();
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
        Schema::dropIfExists('ticket_guylines');
    }
};
