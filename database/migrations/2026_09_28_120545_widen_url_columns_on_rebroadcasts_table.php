<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rebroadcasts', function (Blueprint $table) {
            $table->text('video_url')->change();
            $table->text('embed_url')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('rebroadcasts', function (Blueprint $table) {
            $table->string('video_url')->change();
            $table->string('embed_url')->nullable()->change();
        });
    }
};
