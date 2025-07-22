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
                'task_type' => 'routine',
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
                'task_type' => 'routine',
                'estimated_time' => 1.5,
                'assigned_date' => now(),
                'started_at' => now()->subHours(2),
            ],
            [
                'title' => 'Perbaikan AC lantai 3 mendadak',
                'description' => 'AC di ruang meeting lantai 3 rusak mendadak, perlu diperbaiki segera karena ada meeting penting',
                'priority' => 'high',
                'status' => 'assigned',
                'category' => 'maintenance',
                'task_type' => 'incidental',
                'is_self_assigned' => true,
                'estimated_time' => 1.0,
                'assigned_date' => now(),
            ],
            [
                'title' => 'Beli supplies darurat',
                'description' => 'Tissue dan sabun cuci tangan habis di beberapa toilet, perlu dibeli segera',
                'priority' => 'medium',
                'status' => 'assigned',
                'category' => 'supplies',
                'task_type' => 'incidental',
                'is_self_assigned' => true,
                'estimated_time' => 0.5,
                'assigned_date' => now(),
            ],
            [
                'title' => 'Cek dan isi dispenser air',
                'description' => 'Mengecek semua dispenser air di setiap lantai dan mengisi yang kosong',
                'priority' => 'low',
                'status' => 'completed',
                'category' => 'supplies',
                'task_type' => 'routine',
                'estimated_time' => 0.5,
                'assigned_date' => now()->subDays(1),
                'started_at' => now()->subDay()->subHours(3),
                'completed_at' => now()->subDay()->subHours(2),
                'completion_notes' => 'Semua dispenser sudah diisi dan dicek kondisinya. Dispenser lantai 3 perlu perbaikan kecil.',
                'feedback_type' => 'excellent',
                'admin_feedback' => 'Pekerjaan sangat baik! Terima kasih sudah melaporkan kondisi dispenser yang perlu perbaikan.',
                'feedback_at' => now()->subHours(1),
            ],
            [
                'title' => 'Request tambahan shift',
                'description' => 'Mohon tambahan shift malam untuk minggu ini karena ada event khusus',
                'priority' => 'medium',
                'status' => 'completed',
                'category' => 'schedule',
                'task_type' => 'incidental',
                'is_self_assigned' => true,
                'estimated_time' => 0,
                'assigned_date' => now()->subDays(1),
                'started_at' => now()->subDay()->subHours(4),
                'completed_at' => now()->subDay()->subHours(3),
                'completion_notes' => 'Sudah mengajukan permohonan ke HRD dengan form yang lengkap.',
                'feedback_type' => 'needs_improvement',
                'admin_feedback' => 'Permohonan sudah disampaikan, namun proses tidak sesuai prosedur. Harap koordinasi dengan supervisor terlebih dahulu sebelum mengajukan ke HRD.',
                'feedback_at' => now()->subHours(2),
                'correction_needed' => true,
            ],
            [
                'title' => 'Bersihkan ruang server',
                'description' => 'Membersihkan ruang server dengan hati-hati, hindari menyentuh peralatan elektronik',
                'priority' => 'medium',
                'status' => 'completed',
                'category' => 'cleaning',
                'task_type' => 'incidental',
                'is_self_assigned' => true,
                'estimated_time' => 1.0,
                'assigned_date' => now()->subDays(2),
                'started_at' => now()->subDays(2)->subHours(2),
                'completed_at' => now()->subDays(2)->subHours(1),
                'completion_notes' => 'Ruang server sudah dibersihkan, debu di filter AC juga sudah dibersihkan.',
                'feedback_type' => 'good',
                'admin_feedback' => 'Pekerjaan bagus, namun lain kali gunakan masker saat membersihkan ruang server.',
                'feedback_at' => now()->subDays(1),
            ],
            [
                'title' => 'Perbaikan lampu koridor',
                'description' => 'Lampu koridor lantai 2 mati, perlu diganti segera untuk keamanan',
                'priority' => 'high',
                'status' => 'completed',
                'category' => 'maintenance',
                'task_type' => 'incidental',
                'is_self_assigned' => true,
                'estimated_time' => 0.5,
                'assigned_date' => now()->subDays(3),
                'started_at' => now()->subDays(3)->subHours(3),
                'completed_at' => now()->subDays(3)->subHours(2),
                'completion_notes' => 'Lampu sudah diganti dengan yang baru, ballast juga dicek kondisinya.',
                'feedback_type' => 'needs_improvement',
                'admin_feedback' => 'Lampu sudah diganti dengan baik, tapi harap koordinasi dengan security saat bekerja di area umum.',
                'feedback_at' => now()->subDays(2),
                'correction_needed' => false,
                'correction_completed_at' => now()->subDays(1),
            ],
        ];

        // Get admin user for feedback
        $admin = User::where('role', 'admin')->first();
        $adminId = $admin ? $admin->id : $user->id;

        foreach ($tasks as $taskData) {
            Task::create(array_merge($taskData, [
                'user_id' => $user->id,
                'assigned_by' => $user->id, // self-assigned untuk testing
                'feedback_by' => isset($taskData['feedback_type']) ? $adminId : null, // admin yang beri feedback
            ]));
        }

        $this->command->info('Task data seeded successfully!');
    }
}
