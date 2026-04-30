<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
    public function user() {
        // each task belongs to user once created
        return $this->belongsTo(User::class);
    }
}
