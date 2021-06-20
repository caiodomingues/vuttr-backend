<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    protected $fillable = [
        'title', 'link', 'description'
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_tool');
    }
}
