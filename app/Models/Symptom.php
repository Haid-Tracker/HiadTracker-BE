<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Symptom extends Model
{
    use HasFactory,HasUuids;

    protected $table = 'symptoms';

    protected $fillable = [
        'id',
        'name',
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    public function cycleRecords()
    {
        return $this->belongsToMany(CycleRecord::class, 'record_has_symptoms', 'symptom_id', 'cycle_record_id');
    }

}
