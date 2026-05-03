<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
    protected $fillable = [
        'title',
        'description',
        'due_date',
        'priority',
        'user_id',
        'status',
    ];
    public function user() {
        // each task belongs to user once created
        return $this->belongsTo(User::class);
    }
}
