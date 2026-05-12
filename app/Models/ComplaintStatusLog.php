<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComplaintStatusLog extends Model
{
    protected $fillable = ['complaint_id', 'admin_id', 'old_status', 'new_status'];

    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }

    public function admin()
    {
        // Relasi kembali ke User sebagai admin yang memproses
        return $this->belongsTo(User::class, 'admin_id');
    }
}
