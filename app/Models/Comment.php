<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['complaint_id', 'user_id', 'body'];

    // Komentar ini milik siapa?
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Komentar ini ada di laporan mana?
    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }
}
