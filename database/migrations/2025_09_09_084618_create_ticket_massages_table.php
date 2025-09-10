<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Hanya buat tabel jika belum ada
        if (!Schema::hasTable('ticket_massages')) {
            Schema::create('ticket_massages', function (Blueprint $table) {
                $table->id();
                $table->foreignId('ticket_id')->constrained()->cascadeOnDelete();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->text('body');
                $table->json('attachments')->nullable();
                $table->boolean('internal')->default(false);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_massages');
    }
};
