<?php

namespace Database\Seeders;

use App\Models\BrandKit;
use App\Models\Color;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::query()->firstOrCreate([
            'email' => 'demo@studiokit.local',
        ], [
            'name' => 'StudioKit Demo',
            'password' => Hash::make('password'),
        ]);

        $workspace = Workspace::query()->firstOrCreate([
            'name' => 'Demo Workspace',
            'created_by' => $user->id,
        ]);

        $workspace->members()->syncWithoutDetaching([
            $user->id => ['role' => 'OWNER'],
        ]);

        $kit = BrandKit::query()->firstOrCreate([
            'workspace_id' => $workspace->id,
            'name' => 'Aurora Coffee',
        ], [
            'tagline' => 'Bright mornings, bold taste',
            'description' => 'A sample kit showing how StudioKit organizes brand assets.',
            'voice_keywords' => ['Warm', 'Energetic', 'Premium'],
            'usage_do' => ['Use primary purple on digital buttons', 'Keep logo padding consistent'],
            'usage_dont' => ['Do not stretch the logo', 'Avoid neon colors'],
        ]);

        Color::query()->firstOrCreate([
            'brand_kit_id' => $kit->id,
            'name' => 'Primary Purple',
            'hex' => '#4F46E5',
        ]);
    }
}
