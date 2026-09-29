<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'category',
        'body',
        'image',
    ];

    /**
     * Estimasi waktu baca artikel
     */
    public function getReadTimeAttribute(): string
    {
        $words = str_word_count(strip_tags($this->body));
        $minutes = ceil($words / 180);
        return max(1, (int)$minutes) . ' min read';
    }
}
