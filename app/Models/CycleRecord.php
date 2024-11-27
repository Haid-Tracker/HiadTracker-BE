<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class CycleRecord extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'start_date',
        'end_date',
        'predicted_date',
        'blood_volume',
        'symptoms',
        'mood',
        'medication',
        'notes'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'predicted_date' => 'date',
        'symptoms' => 'json',
        'medication' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function feedback()
    {
        return $this->hasOne(Feedback::class);
    }
}
