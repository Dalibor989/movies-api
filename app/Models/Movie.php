<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'director',
        'image_url',
        'duration',
        'release_date',
        'genre',
    ];


    public static function search_by_title($title = null)
    {
        $query = self::query();

        if ($title) {
            $title = strtolower($title);

            $query->whereRaw('lower(title) like "%' . $title . '%"');
        }

        return $query;
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}

