<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'check_in',
        'check_out',
        'location',
        'notes',
        'status'
    ];

    protected $casts = [
        'date' => 'date',
        'check_in' => 'datetime:H:i',
        'check_out' => 'datetime:H:i',
    ];

    /**
     * Get the user that owns the attendance
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Calculate work duration in hours
     */
    public function getWorkDurationAttribute()
    {
        if (!$this->check_in || !$this->check_out) {
            return null;
        }

        // Parse times in Jakarta timezone
        $checkIn = Carbon::parse($this->check_in)->setTimezone('Asia/Jakarta');
        $checkOut = Carbon::parse($this->check_out)->setTimezone('Asia/Jakarta');
        
        return $checkOut->diffInHours($checkIn, true);
    }

    /**
     * Check if check-in is late
     */
    public function isLate()
    {
        if (!$this->check_in) {
            return false;
        }

        $standardCheckIn = Carbon::parse('08:00')->setTimezone('Asia/Jakarta');
        $actualCheckIn = Carbon::parse($this->check_in)->setTimezone('Asia/Jakarta');
        
        return $actualCheckIn->gt($standardCheckIn);
    }

    /**
     * Check if check-out is early
     */
    public function isEarlyLeave()
    {
        if (!$this->check_out) {
            return false;
        }

        $standardCheckOut = Carbon::parse('17:00')->setTimezone('Asia/Jakarta');
        $actualCheckOut = Carbon::parse($this->check_out)->setTimezone('Asia/Jakarta');
        
        return $actualCheckOut->lt($standardCheckOut);
    }
}
