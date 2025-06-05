<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    public function members()
    {
        return $this->belongsToMany(User::class);
    }

    public function jobPosts()
    {
        return $this->hasMany(JobPost::class);
    }
}
