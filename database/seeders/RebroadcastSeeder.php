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
