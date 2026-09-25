<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\PrayerRequest;
use App\Models\Rebroadcast;
use App\Models\RebroadcastParticipant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RebroadcastSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@thegathering.test'],
            ['name' => 'Media Team', 'password' => Hash::make('password'), 'role' => 'admin']
        );

        $member = User::firstOrCreate(
            ['email' => 'member@thegathering.test'],
            ['name' => 'Grace Adeyemi', 'password' => Hash::make('password'), 'role' => 'member']
        );

        $active = Rebroadcast::create([
            'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'embed_url' => Rebroadcast::buildEmbed('https://www.youtube.com/watch?v=dQw4w9WgXcQ')['embed'],
            'video_provider' => 'youtube',
            'title' => 'Living in the Overflow',
            'speaker' => 'Pastor Chris Oyakhilome',
            'series' => 'Sunday Service',
            'scripture_reference' => 'John 10:10',
            'notes' => "God's desire for you goes beyond survival — He wants you living in abundance, in every area of your life.",
            'status' => 'active',
            'scheduled_at' => now()->subMinutes(20),
        ]);

        Rebroadcast::create([
            'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'embed_url' => Rebroadcast::buildEmbed('https://www.youtube.com/watch?v=dQw4w9WgXcQ')['embed'],
            'video_provider' => 'youtube',
            'title' => 'Midweek Communion Service',
            'series' => 'Communion',
            'status' => 'scheduled',
            'scheduled_at' => now()->addDays(2)->setTime(18, 0),
        ]);

        Rebroadcast::create([
            'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'embed_url' => Rebroadcast::buildEmbed('https://www.youtube.com/watch?v=dQw4w9WgXcQ')['embed'],
            'video_provider' => 'youtube',
            'title' => 'The Believer\'s Authority',
            'speaker' => 'Pastor Chris Oyakhilome',
            'status' => 'archived',
            'scheduled_at' => now()->subWeek(),
        ]);

        PrayerRequest::create([
            'rebroadcast_id' => $active->id,
            'name' => 'Grace A.',
            'request_text' => 'Please pray for my mother\'s recovery and for strength for my family during this season.',
            'status' => 'new',
        ]);

        PrayerRequest::create([
            'is_anonymous' => true,
            'request_text' => 'Praying for direction on a big decision I need to make this month.',
            'status' => 'new',
        ]);

        Comment::create([
            'rebroadcast_id' => $active->id,
            'user_id' => $member->id,
            'body' => 'Glory! This word is exactly what I needed today.',
        ]);

        Comment::create([
            'rebroadcast_id' => $active->id,
            'user_id' => $admin->id,
            'body' => 'So glad you\'re here with us, Grace — God bless you.',
            'is_admin_comment' => true,
        ]);

        RebroadcastParticipant::updateOrCreate(
            ['rebroadcast_id' => $active->id, 'user_id' => $member->id],
            ['last_seen_at' => now()]
        );
        RebroadcastParticipant::updateOrCreate(
            ['rebroadcast_id' => $active->id, 'user_id' => $admin->id],
            ['last_seen_at' => now()]
        );
    }
}
