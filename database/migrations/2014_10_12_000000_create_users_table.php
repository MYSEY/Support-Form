<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate:refresh --path=database/migrations/2014_10_12_000000_create_users_table.php
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user');
            $table->string('name');
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('department_id')->nullable(); //integer('department_id');
            $table->string('branch_id')->nullable(); //integer('branch_id');
            $table->string('signature')->nullable();
            $table->enum('afterreply', ['0', '1', '2'])->default('0');
            $table->enum('autostart', ['0', '1'])->default('0');
            $table->smallInteger('autoreload')->length(5)->nullable();
            $table->string('secmin')->nullable();
            $table->enum('notify_customer_new', ['0', '1'])->default('0');
            $table->enum('notify_customer_reply', ['0', '1'])->default('0');
            $table->enum('show_suggested', ['0', '1'])->default('0');
            $table->enum('notify_new_unassigned', ['0', '1'])->default('0');
            $table->enum('notify_new_my', ['0', '1'])->default('0');
            $table->enum('notify_reply_unassigned', ['0', '1'])->default('0');
            $table->enum('notify_reply_my', ['0', '1'])->default('0');
            $table->enum('notify_assigned', ['0', '1'])->default('0');
            $table->enum('notify_pm', ['0', '1'])->default('0');
            $table->enum('notify_note', ['0', '1'])->default('0');
            $table->enum('notify_overdue_unassigned', ['0', '1'])->default('0');
            $table->enum('notify_overdue_my', ['0', '1'])->default('0');
            $table->boolean('autoassign')->nullable();
            $table->integer('rating')->nullable();
            $table->string('status')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert(
            [
                [
                    'user'=>'Admin',
                    'name'=>'Admin',
                    'email'=>'admin@gmail.com',
                    'password'=>Hash::make('Camma@123'),
                    'status'=> 'Active',
                ]
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
