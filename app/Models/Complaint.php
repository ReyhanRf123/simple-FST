<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = [
        'user_id', 'facility_id', 'location', 'description', 
        'severity_level', 'priority_score', 'status', 'image', 'resolved_image'
    ];

    // Relasi ke User (Pelapor)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Fasilitas
    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }

    // Relasi ke Log Status
    public function statusLogs()
    {
        return $this->hasMany(ComplaintStatusLog::class);
    }

    public static function calculatePriority($facilityId, $severityLevel)
    {
        $facility = Facility::find($facilityId);
        $skorFasilitas = $facility ? $facility->facility_score : 1;

        // Mapping Skor Dampak berdasarkan tingkat keparahan
        $skorDampak = match ($severityLevel) {
            'kritis' => 3,
            'sedang' => 2,
            'ringan' => 1,
            default  => 1,
        };

        return $skorFasilitas * $skorDampak;
    }
}