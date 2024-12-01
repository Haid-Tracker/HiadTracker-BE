<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class UserProfile extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'profiles';
    protected $fillable = [
        'id',
        'user_id',
        'birth_date',
        'weight',
        'height',
        'photo',
        'cycle_length',
        'last_period_date'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
