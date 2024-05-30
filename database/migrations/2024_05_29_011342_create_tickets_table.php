<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate:refresh --path=database/migrations/2024_05_29_011342_create_tickets_table.php
     */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('trackid');
            $table->integer('department_id')->nullable();
            $table->integer('branch_id')->nullable();
            $table->enum('priority', ['0', '1', '2', '3'])->default('0');
            $table->string('subject')->nullable();
            $table->mediumText('message')->nullable();
            $table->message_html('message_html')->nullable();
            $table->bigInteger('dt')->nullable();
            $table->bigInteger('lastchange')->nullable();
            $table->bigInteger('firstreply')->nullable();
            $table->bigInteger('closedat')->nullable();
            $table->string('articles')->nullable();
            $table->string('ip')->nullable();
            $table->string('language')->nullable();
            $table->integer('status')->nullable();
            $table->mediumInteger('openedby')->nullable();
            $table->smallInteger('firstreplyby')->nullable();
            $table->mediumInteger('closedby')->nullable();
            $table->smallInteger('replies')->nullable();
            $table->smallInteger('staffreplies')->nullable();
            $table->smallInteger('owner')->nullable();
            $table->mediumInteger('assignedby')->nullable();
            $table->time('time_worked')->nullable();
            $table->enum('lastreplier', ['0', '1'])->default('0');
            $table->smallInteger('replierid')->nullable();
            $table->enum('archive', ['0', '1'])->default('0');
            $table->enum('locked', ['0', '1'])->default('0');
            $table->mediumText('attachments')->nullable();
            $table->mediumText('merged')->nullable();
            $table->mediumText('history')->nullable();
            $table->timestamp('due_date')->nullable();
            $table->integer('overdue_email_sent')->nullable();
            $table->integer('satisfaction_email_sent')->nullable();
            $table->timestamp('satisfaction_email_dt')->nullable();
            $table->json('issue_type')->nullable();
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
        Schema::dropIfExists('tickets');
    }
};
