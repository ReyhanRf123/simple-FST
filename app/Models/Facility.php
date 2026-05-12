<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $fillable = ['facility_name', 'facility_score'];

    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }
}
