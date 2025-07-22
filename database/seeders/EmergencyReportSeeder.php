<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EmergencyReport;
use App\Models\User;

class EmergencyReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get regular user
        $user = User::where('email', 'user@example.com')->first();
        
        if ($user) {
            // Create sample emergency reports
            EmergencyReport::create([
                'user_id' => $user->id,
                'title' => 'Fire Emergency in Building A',
                'description' => 'There is a small fire in the storage room on the 3rd floor of Building A. The fire alarm has been triggered and employees are evacuating the floor. Immediate assistance is required.',
                'status' => 'resolved',
                'priority' => 'critical',
                'location' => 'Building A, 3rd Floor, Storage Room',
                'reported_at' => now()->subDays(5),
                'resolved_at' => now()->subDays(5)->addHours(2),
                'admin_notes' => 'Fire department responded quickly. Fire was contained to storage room. No injuries reported. Cause was electrical fault in old equipment.',
            ]);

            EmergencyReport::create([
                'user_id' => $user->id,
                'title' => 'Power Outage in Main Server Room',
                'description' => 'Complete power failure in the main server room. All servers are down and running on backup power which will last approximately 30 minutes. This is affecting our main systems and customer services.',
                'status' => 'under_review',
                'priority' => 'high',
                'location' => 'Building B, Basement, Server Room',
                'reported_at' => now()->subDays(2),
                'admin_notes' => 'Electrical team has been contacted. Investigating the cause of power failure. Backup generators are being prepared.',
            ]);

            EmergencyReport::create([
                'user_id' => $user->id,
                'title' => 'Medical Emergency - Employee Injury',
                'description' => 'An employee has fallen down the stairs near the main entrance and appears to have injured their leg. They are conscious but in pain and unable to move. Medical assistance is needed immediately.',
                'status' => 'resolved',
                'priority' => 'high',
                'location' => 'Main Building, Ground Floor, Near Main Entrance',
                'reported_at' => now()->subDays(7),
                'resolved_at' => now()->subDays(7)->addMinutes(15),
                'admin_notes' => 'Ambulance arrived within 10 minutes. Employee was taken to hospital with suspected sprained ankle. Full recovery expected.',
            ]);

            EmergencyReport::create([
                'user_id' => $user->id,
                'title' => 'Security Breach - Unauthorized Access',
                'description' => 'Security cameras detected an unauthorized person attempting to access the restricted area near the data center. The person was seen trying to force open the security door.',
                'status' => 'pending',
                'priority' => 'high',
                'location' => 'Building B, 2nd Floor, Data Center Area',
                'reported_at' => now()->subHours(3),
            ]);

            EmergencyReport::create([
                'user_id' => $user->id,
                'title' => 'Water Leak in Office Area',
                'description' => 'Large water leak discovered in the accounting department. Water is coming from the ceiling and has damaged several workstations and equipment. The area needs to be evacuated.',
                'status' => 'under_review',
                'priority' => 'medium',
                'location' => 'Building A, 2nd Floor, Accounting Department',
                'reported_at' => now()->subDays(1),
                'admin_notes' => 'Maintenance team is investigating the source of the leak. Affected area has been cordoned off.',
            ]);

            EmergencyReport::create([
                'user_id' => $user->id,
                'title' => 'Chemical Spill in Laboratory',
                'description' => 'Small chemical spill occurred in the research laboratory. The spill appears to be a cleaning solution but proper hazmat procedures should be followed for cleanup.',
                'status' => 'resolved',
                'priority' => 'medium',
                'location' => 'Building C, 1st Floor, Research Lab',
                'reported_at' => now()->subDays(3),
                'resolved_at' => now()->subDays(3)->addHours(1),
                'admin_notes' => 'Hazmat team cleaned up the spill following proper procedures. Area was decontaminated and cleared for use.',
            ]);
        }
    }
}
