<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Profile extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'birth_date',
        'weight',
        'height',
        'photo',
        'cycle_length',
        'last_period_date'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'last_period_date' => 'date',
        'weight' => 'decimal:2',
        'height' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
