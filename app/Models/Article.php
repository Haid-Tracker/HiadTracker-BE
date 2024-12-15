<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'articles';
    protected $fillable = [
        'id',
        'title',
        'hero_photo',
        'content',
        'author'
    ];

    public function categories()
    {
        return $this->belongsToMany(CategoryArticle::class, 'article_has_categories', 'article_id', 'category_id');
    }

    public function cycleRecords()
    {
        return $this->belongsToMany(CycleRecord::class, 'record_has_articles', 'article_id', 'cycle_record_id');
    }
}
