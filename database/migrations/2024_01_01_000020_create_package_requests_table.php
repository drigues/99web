<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('package_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->enum('package_type', ['essencial', 'corporativo', 'personalizado']);
            $table->string('budget')->nullable();
            $table->text('project_description');
            $table->boolean('has_domain')->default(false);
            $table->boolean('has_hosting')->default(false);
            $table->string('current_website')->nullable();
            $table->date('deadline')->nullable();
            $table->enum('status', ['novo', 'contactado', 'proposta_enviada', 'aprovado', 'recusado'])->default('novo');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('package_requests');
    }
};
