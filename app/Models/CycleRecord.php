<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\Feedback;

class CycleRecord extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'start_date',
        'end_date',
        'predicted_date',
        'blood_volume',
        'mood',
        'cycle_regularity',
        'medication',
        'notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function feedback()
    {
        return $this->hasOne(Feedback::class);
    }

    public function symptoms()
    {
        return $this->belongsToMany(Symptom::class, 'record_has_symptoms', 'cycle_record_id', 'symptom_id');
    }

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'record_has_articles', 'cycle_record_id', 'article_id');
    }

}
