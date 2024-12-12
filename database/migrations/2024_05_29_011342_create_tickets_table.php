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
            $table->string('trackid')->nullable();
            $table->integer('department_id_from')->nullable();
            $table->integer('department_id')->nullable();
            $table->integer('branch_id')->nullable();
            $table->integer('priority')->nullable();
            $table->string('subject')->nullable();
            $table->longText('message')->nullable();
            $table->mediumText('message_html')->nullable();
            $table->timestamp('dt')->nullable();
            $table->timestamp('lastchange')->nullable();
            $table->timestamp('firstreply')->nullable();
            $table->timestamp('closedat')->nullable();
            $table->string('articles')->nullable();
            $table->string('ip')->nullable();
            $table->string('language')->nullable();
            $table->integer('status')->nullable();
            $table->mediumInteger('openedby')->nullable();
            $table->smallInteger('firstreplyby')->nullable();
            $table->mediumInteger('closedby')->nullable();
            $table->smallInteger('replies')->nullable();
            $table->smallInteger('staffreplies')->nullable();
            $table->string('owner')->nullable();
            $table->string('assignedby')->nullable();
            $table->time('time_worked')->nullable();
            $table->integer('lastreplier')->nullable();
            $table->integer('replierid')->nullable();
            $table->integer('archive')->default('0')->nullable();
            $table->integer('locked')->default('0');
            $table->mediumText('attachments')->nullable();
            $table->mediumText('merged')->nullable();
            $table->mediumText('history')->nullable();
            $table->timestamp('due_date')->nullable();
            $table->integer('overdue_email_sent')->nullable();
            $table->integer('satisfaction_email_sent')->nullable();
            $table->date('satisfaction_email_dt')->nullable();
            $table->integer('ticket_type')->nullable();
            $table->integer('issue_type')->nullable();
            $table->string('custom1')->nullable();
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
