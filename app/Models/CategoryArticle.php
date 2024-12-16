<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryArticle extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'category_article';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'name'
    ];

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'article_has_categories', 'category_id', 'article_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }
}
