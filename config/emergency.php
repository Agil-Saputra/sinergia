<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Emergency Contact Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains configuration for emergency contacts and settings
    | used throughout the emergency reporting system.
    |
    */

    'supervisor_phone' => env('SUPERVISOR_PHONE', '+6281234567890'),
    'security_phone' => env('SECURITY_PHONE', '+6281234567891'),
    
    'emergency_contacts' => [
        'supervisor' => [
            'name' => 'Supervisor',
            'phone' => env('SUPERVISOR_PHONE', '+6281234567890'),
        ],
        'security' => [
            'name' => 'Security',
            'phone' => env('SECURITY_PHONE', '+6281234567891'),
        ],
        'hr' => [
            'name' => 'HR Department',
            'phone' => env('HR_PHONE', '+6281234567892'),
        ],
    ],

    'allowed_file_types' => [
        'images' => ['jpg', 'jpeg', 'png', 'gif'],
        'videos' => ['mp4', 'avi', 'mov', 'wmv'],
        'documents' => ['pdf', 'doc', 'docx', 'txt'],
    ],

    'max_file_size' => 10240, // 10MB in KB
];
