<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rebroadcast_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('rebroadcast_id')->constrained('rebroadcasts')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamp('last_seen_at');
            $table->timestamps();

            $table->unique(['rebroadcast_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rebroadcast_participants');
    }
};
