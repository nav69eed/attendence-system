<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assigned_by')->constrained('users');
            $table->foreignId('assigned_to')->constrained('users'); // Remove nullable
            $table->string('title');
            $table->text('description');
            $table->date('due_date')->nullable();
            $table->text('response')->nullable();
            $table->enum('status', ['pending', 'completed', 'approved', 'rejected'])->default('pending');
            $table->text('feedback')->nullable();
            $table->json('attachments')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};