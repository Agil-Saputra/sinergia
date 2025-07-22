<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first user with role 'user'
        $user = User::where('role', 'user')->first();
        
        if (!$user) {
            $this->command->warn('No user with role "user" found. Skipping task seeding.');
            return;
        }

        $tasks = [
            [
                'title' => 'Bersihkan toilet lantai 2',
                'description' => 'Membersihkan semua toilet di lantai 2 termasuk lantai, kaca, dan perlengkapan toilet',
                'priority' => 'high',
                'status' => 'in_progress',
                'category' => 'cleaning',
                'estimated_time' => 2.0,
                'assigned_date' => now(),
                'started_at' => now()->subHours(1),
            ],
            [
                'title' => 'Sapu dan pel ruang meeting',
                'description' => 'Membersihkan ruang meeting A dan B, termasuk meja, kursi, dan lantai',
                'priority' => 'medium',
                'status' => 'in_progress',
                'category' => 'cleaning',
                'estimated_time' => 1.5,
                'assigned_date' => now(),
                'started_at' => now()->subHours(2),
            ],
            [
                'title' => 'Cek dan isi dispenser air',
                'description' => 'Mengecek semua dispenser air di setiap lantai dan mengisi yang kosong',
                'priority' => 'low',
                'status' => 'completed',
                'category' => 'supplies',
                'estimated_time' => 0.5,
                'assigned_date' => now()->subDays(1),
                'started_at' => now()->subDay()->subHours(3),
                'completed_at' => now()->subDay()->subHours(2),
                'completion_notes' => 'Semua dispenser sudah diisi dan dicek kondisinya. Dispenser lantai 3 perlu perbaikan kecil.',
            ],
            [
                'title' => 'Bersihkan jendela lobby',
                'description' => 'Membersihkan semua jendela di area lobby bagian dalam dan luar',
                'priority' => 'medium',
                'status' => 'assigned',
                'category' => 'cleaning',
                'estimated_time' => 3.0,
                'assigned_date' => now()->addDays(1),
            ],
            [
                'title' => 'Periksa kebersihan pantry',
                'description' => 'Membersihkan pantry, kulkas, microwave, dan area makan',
                'priority' => 'high',
                'status' => 'in_progress',
                'category' => 'cleaning',
                'estimated_time' => 1.0,
                'assigned_date' => now(),
                'started_at' => now()->subMinutes(30),
            ]
        ];

        foreach ($tasks as $taskData) {
            Task::create(array_merge($taskData, [
                'user_id' => $user->id,
                'assigned_by' => $user->id // self-assigned untuk testing
            ]));
        }

        $this->command->info('Task data seeded successfully!');
    }
}
