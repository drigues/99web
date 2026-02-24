<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meeting_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->string('current_website')->nullable();
            $table->date('preferred_date');
            $table->time('preferred_time');
            $table->enum('meeting_type', ['video_call', 'phone', 'presencial'])->default('video_call');
            $table->text('objectives');
            $table->enum('status', ['pendente', 'confirmado', 'realizado', 'cancelado', 'reagendado'])->default('pendente');
            $table->text('admin_notes')->nullable();
            $table->date('confirmed_date')->nullable();
            $table->time('confirmed_time')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meeting_requests');
    }
};
