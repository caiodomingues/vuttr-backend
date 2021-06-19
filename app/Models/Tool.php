<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    protected $fillable = [
        'name', 'link', 'description'
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
