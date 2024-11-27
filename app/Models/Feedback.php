<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Feedback extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'cycle_record_id',
        'status',
        'feedback'
    ];

    public function cycleRecord()
    {
        return $this->belongsTo(CycleRecord::class);
    }
}
