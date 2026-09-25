<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rebroadcasts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('video_url');
            $table->string('embed_url')->nullable();
            $table->enum('video_provider', ['youtube', 'vimeo', 'direct'])->default('youtube');
            $table->string('title');
            $table->string('speaker')->nullable();
            $table->string('series')->nullable();
            $table->string('scripture_reference')->nullable();
            $table->longText('notes')->nullable();
            $table->longText('bulletin')->nullable();
            $table->enum('status', ['active', 'scheduled', 'archived'])->default('scheduled');
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamps();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rebroadcasts');
    }
};
