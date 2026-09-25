<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prayer_requests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('rebroadcast_id')->nullable()->constrained('rebroadcasts')->nullOnDelete();
            $table->string('name')->nullable();
            $table->string('contact')->nullable();
            $table->boolean('is_anonymous')->default(false);
            $table->text('request_text');
            $table->enum('status', ['new', 'prayed_for', 'followed_up'])->default('new');
            $table->timestamps();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prayer_requests');
    }
};
