<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use App\Models\Attendance;
use App\Models\EmergencyReport;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ExportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

    public function tasks()
    {
        try {
            // Try Excel export first
            return $this->exportTasksExcel();
        } catch (\Exception $e) {
            // Fallback to CSV if Excel fails
            return $this->exportTasksCSV();
        }
    }

    public function users()
    {
        try {
            return $this->exportUsersExcel();
        } catch (\Exception $e) {
            return $this->exportUsersCSV();
        }
    }

    public function attendance()
    {
        try {
            return $this->exportAttendanceExcel();
        } catch (\Exception $e) {
            return $this->exportAttendanceCSV();
        }
    }

    public function emergencyReports()
    {
        try {
            return $this->exportEmergencyExcel();
        } catch (\Exception $e) {
            return $this->exportEmergencyCSV();
        }
    }

    private function exportTasksExcel()
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $tasks = Task::with(['user', 'feedbackBy'])->get();
        
        // Set headers
        $headers = [
            'ID', 'Judul', 'Deskripsi', 'Karyawan', 'Kode Karyawan', 'Prioritas', 
            'Kategori', 'Status', 'Tipe Tugas', 'Tanggal Ditugaskan', 'Tanggal Selesai',
            'Estimasi Waktu (jam)', 'Catatan', 'Feedback Admin', 'Tipe Feedback',
            'Feedback Oleh', 'Tanggal Feedback', 'Perlu Perbaikan', 'Perbaikan Selesai'
        ];
        
        $sheet->fromArray($headers, null, 'A1');
        
        // Style headers
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '2563EB']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
        ];
        $sheet->getStyle('A1:S1')->applyFromArray($headerStyle);
        
        // Add data
        $row = 2;
        foreach ($tasks as $task) {
            $data = [
                $task->id,
                $task->title,
                $task->description,
                $task->user->name ?? '',
                $task->user->employee_code ?? '',
                ucfirst($task->priority),
                ucfirst($task->category ?? ''),
                $task->status_text ?? $task->status,
                $task->task_type_text ?? $task->task_type ?? '',
                $task->assigned_date ? $task->assigned_date->format('Y-m-d') : '',
                $task->completed_at ? $task->completed_at->format('Y-m-d H:i:s') : '',
                $task->estimated_time ?? '',
                $task->notes ?? '',
                $task->admin_feedback ?? '',
                $task->feedback_type_text ?? $task->feedback_type ?? '',
                $task->feedbackBy?->name ?? '',
                $task->feedback_at ? $task->feedback_at->format('Y-m-d H:i:s') : '',
                $task->correction_needed ? 'Ya' : 'Tidak',
                $task->correction_completed_at ? $task->correction_completed_at->format('Y-m-d H:i:s') : ''
            ];
            $sheet->fromArray($data, null, 'A' . $row);
            $row++;
        }
        
        // Auto-size columns
        foreach (range('A', 'S') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
        
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'data_tugas_' . date('Y-m-d_H-i-s') . '.xlsx';
        
        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    private function exportTasksCSV()
    {
        $tasks = Task::with(['user', 'feedbackBy'])->get();
        
        $headers = [
            'ID', 'Judul', 'Deskripsi', 'Karyawan', 'Kode Karyawan', 'Prioritas', 
            'Kategori', 'Status', 'Tipe Tugas', 'Tanggal Ditugaskan', 'Tanggal Selesai',
            'Estimasi Waktu (jam)', 'Catatan', 'Feedback Admin', 'Tipe Feedback',
            'Feedback Oleh', 'Tanggal Feedback', 'Perlu Perbaikan', 'Perbaikan Selesai'
        ];
        
        $filename = 'data_tugas_' . date('Y-m-d_H-i-s') . '.csv';
        
        return response()->streamDownload(function () use ($tasks, $headers) {
            $handle = fopen('php://output', 'w');
            
            // Add UTF-8 BOM for proper encoding
            fwrite($handle, "\xEF\xBB\xBF");
            
            // Add headers
            fputcsv($handle, $headers);
            
            // Add data
            foreach ($tasks as $task) {
                $data = [
                    $task->id,
                    $task->title,
                    $task->description,
                    $task->user->name ?? '',
                    $task->user->employee_code ?? '',
                    ucfirst($task->priority),
                    ucfirst($task->category ?? ''),
                    $task->status_text ?? $task->status,
                    $task->task_type_text ?? $task->task_type ?? '',
                    $task->assigned_date ? $task->assigned_date->format('Y-m-d') : '',
                    $task->completed_at ? $task->completed_at->format('Y-m-d H:i:s') : '',
                    $task->estimated_time ?? '',
                    $task->notes ?? '',
                    $task->admin_feedback ?? '',
                    $task->feedback_type_text ?? $task->feedback_type ?? '',
                    $task->feedbackBy?->name ?? '',
                    $task->feedback_at ? $task->feedback_at->format('Y-m-d H:i:s') : '',
                    $task->correction_needed ? 'Ya' : 'Tidak',
                    $task->correction_completed_at ? $task->correction_completed_at->format('Y-m-d H:i:s') : ''
                ];
                fputcsv($handle, $data);
            }
            
            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    private function exportUsersExcel()
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $users = User::all();
        
        // Set headers
        $headers = [
            'ID', 'Nama', 'Email', 'Kode Karyawan', 'Role', 'Nomor Telepon',
            'Tanggal Bergabung', 'Email Verified At', 'Created At', 'Updated At'
        ];
        
        $sheet->fromArray($headers, null, 'A1');
        
        // Style headers
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '16A34A']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
        ];
        $sheet->getStyle('A1:J1')->applyFromArray($headerStyle);
        
        // Add data
        $row = 2;
        foreach ($users as $user) {
            $data = [
                $user->id,
                $user->name,
                $user->email,
                $user->employee_code ?? '',
                ucfirst($user->role),
                $user->phone_number ?? '',
                $user->join_date ? $user->join_date->format('Y-m-d') : '',
                $user->email_verified_at ? $user->email_verified_at->format('Y-m-d H:i:s') : '',
                $user->created_at->format('Y-m-d H:i:s'),
                $user->updated_at->format('Y-m-d H:i:s')
            ];
            $sheet->fromArray($data, null, 'A' . $row);
            $row++;
        }
        
        // Auto-size columns
        foreach (range('A', 'J') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
        
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'data_karyawan_' . date('Y-m-d_H-i-s') . '.xlsx';
        
        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    private function exportUsersCSV()
    {
        $users = User::all();
        
        $headers = [
            'ID', 'Nama', 'Email', 'Kode Karyawan', 'Role', 'Nomor Telepon',
            'Tanggal Bergabung', 'Email Verified At', 'Created At', 'Updated At'
        ];
        
        $filename = 'data_karyawan_' . date('Y-m-d_H-i-s') . '.csv';
        
        return response()->streamDownload(function () use ($users, $headers) {
            $handle = fopen('php://output', 'w');
            
            // Add UTF-8 BOM for proper encoding
            fwrite($handle, "\xEF\xBB\xBF");
            
            // Add headers
            fputcsv($handle, $headers);
            
            // Add data
            foreach ($users as $user) {
                $data = [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->employee_code ?? '',
                    ucfirst($user->role),
                    $user->phone_number ?? '',
                    $user->join_date ? $user->join_date->format('Y-m-d') : '',
                    $user->email_verified_at ? $user->email_verified_at->format('Y-m-d H:i:s') : '',
                    $user->created_at->format('Y-m-d H:i:s'),
                    $user->updated_at->format('Y-m-d H:i:s')
                ];
                fputcsv($handle, $data);
            }
            
            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    private function exportAttendanceExcel()
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $attendances = Attendance::with('user')->get();
        
        // Set headers
        $headers = [
            'ID', 'Karyawan', 'Kode Karyawan', 'Tanggal', 'Jam Masuk', 'Jam Keluar',
            'Status', 'Keterangan', 'Created At', 'Updated At'
        ];
        
        $sheet->fromArray($headers, null, 'A1');
        
        // Style headers
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '7C3AED']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
        ];
        $sheet->getStyle('A1:J1')->applyFromArray($headerStyle);
        
        // Add data
        $row = 2;
        foreach ($attendances as $attendance) {
            $data = [
                $attendance->id,
                $attendance->user->name ?? '',
                $attendance->user->employee_code ?? '',
                $attendance->date ? $attendance->date->format('Y-m-d') : '',
                $attendance->check_in ? $attendance->check_in->format('H:i:s') : '',
                $attendance->check_out ? $attendance->check_out->format('H:i:s') : '',
                $attendance->status ?? '',
                $attendance->notes ?? '',
                $attendance->created_at->format('Y-m-d H:i:s'),
                $attendance->updated_at->format('Y-m-d H:i:s')
            ];
            $sheet->fromArray($data, null, 'A' . $row);
            $row++;
        }
        
        // Auto-size columns
        foreach (range('A', 'J') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
        
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'data_absensi_' . date('Y-m-d_H-i-s') . '.xlsx';
        
        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    private function exportAttendanceCSV()
    {
        $attendances = Attendance::with('user')->get();
        
        $headers = [
            'ID', 'Karyawan', 'Kode Karyawan', 'Tanggal', 'Jam Masuk', 'Jam Keluar',
            'Status', 'Keterangan', 'Created At', 'Updated At'
        ];
        
        $filename = 'data_absensi_' . date('Y-m-d_H-i-s') . '.csv';
        
        return response()->streamDownload(function () use ($attendances, $headers) {
            $handle = fopen('php://output', 'w');
            
            // Add UTF-8 BOM for proper encoding
            fwrite($handle, "\xEF\xBB\xBF");
            
            // Add headers
            fputcsv($handle, $headers);
            
            // Add data
            foreach ($attendances as $attendance) {
                $data = [
                    $attendance->id,
                    $attendance->user->name ?? '',
                    $attendance->user->employee_code ?? '',
                    $attendance->date ? $attendance->date->format('Y-m-d') : '',
                    $attendance->check_in ? $attendance->check_in->format('H:i:s') : '',
                    $attendance->check_out ? $attendance->check_out->format('H:i:s') : '',
                    $attendance->status ?? '',
                    $attendance->notes ?? '',
                    $attendance->created_at->format('Y-m-d H:i:s'),
                    $attendance->updated_at->format('Y-m-d H:i:s')
                ];
                fputcsv($handle, $data);
            }
            
            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    private function exportEmergencyExcel()
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $emergencies = EmergencyReport::with('user')->get();
        
        // Set headers
        $headers = [
            'ID', 'Pelapor', 'Kode Karyawan', 'Tanggal Laporan', 'Lokasi',
            'Deskripsi', 'Tingkat Kedaruratan', 'Status', 'Respon', 'Ditangani Oleh',
            'Tanggal Respon', 'Created At', 'Updated At'
        ];
        
        $sheet->fromArray($headers, null, 'A1');
        
        // Style headers
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'DC2626']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
        ];
        $sheet->getStyle('A1:M1')->applyFromArray($headerStyle);
        
        // Add data
        $row = 2;
        foreach ($emergencies as $emergency) {
            $data = [
                $emergency->id,
                $emergency->user->name ?? '',
                $emergency->user->employee_code ?? '',
                $emergency->report_date ? $emergency->report_date->format('Y-m-d H:i:s') : '',
                $emergency->location ?? '',
                $emergency->description ?? '',
                $emergency->emergency_level ?? '',
                $emergency->status ?? '',
                $emergency->response ?? '',
                $emergency->handled_by ?? '',
                $emergency->response_date ? $emergency->response_date->format('Y-m-d H:i:s') : '',
                $emergency->created_at->format('Y-m-d H:i:s'),
                $emergency->updated_at->format('Y-m-d H:i:s')
            ];
            $sheet->fromArray($data, null, 'A' . $row);
            $row++;
        }
        
        // Auto-size columns
        foreach (range('A', 'M') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
        
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'data_laporan_darurat_' . date('Y-m-d_H-i-s') . '.xlsx';
        
        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    private function exportEmergencyCSV()
    {
        $emergencies = EmergencyReport::with('user')->get();
        
        $headers = [
            'ID', 'Pelapor', 'Kode Karyawan', 'Tanggal Laporan', 'Lokasi',
            'Deskripsi', 'Tingkat Kedaruratan', 'Status', 'Respon', 'Ditangani Oleh',
            'Tanggal Respon', 'Created At', 'Updated At'
        ];
        
        $filename = 'data_laporan_darurat_' . date('Y-m-d_H-i-s') . '.csv';
        
        return response()->streamDownload(function () use ($emergencies, $headers) {
            $handle = fopen('php://output', 'w');
            
            // Add UTF-8 BOM for proper encoding
            fwrite($handle, "\xEF\xBB\xBF");
            
            // Add headers
            fputcsv($handle, $headers);
            
            // Add data
            foreach ($emergencies as $emergency) {
                $data = [
                    $emergency->id,
                    $emergency->user->name ?? '',
                    $emergency->user->employee_code ?? '',
                    $emergency->report_date ? $emergency->report_date->format('Y-m-d H:i:s') : '',
                    $emergency->location ?? '',
                    $emergency->description ?? '',
                    $emergency->emergency_level ?? '',
                    $emergency->status ?? '',
                    $emergency->response ?? '',
                    $emergency->handled_by ?? '',
                    $emergency->response_date ? $emergency->response_date->format('Y-m-d H:i:s') : '',
                    $emergency->created_at->format('Y-m-d H:i:s'),
                    $emergency->updated_at->format('Y-m-d H:i:s')
                ];
                fputcsv($handle, $data);
            }
            
            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }
}
