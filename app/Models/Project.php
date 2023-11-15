<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'url',
        'desc'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public static function booted() {
        static::creating(function (Project $project) {
            $project->slug = strtolower(Str::slug($project->title . '-'));
        });
    }

    protected function image(): Attribute {
        return Attribute::make(
            get: fn ($image) => asset('/storage/projects/' . $image),
        );
    }
}
