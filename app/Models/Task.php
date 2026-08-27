<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\TaskObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy(TaskObserver::class)]
class Task extends Model
{
    use HasFactory; // Added: enables Task::factory() for seeding and tests

    protected $fillable = [
        'title',
        'description',
        'due_date',
        'priority',
        'user_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // added a function which creates a timestamp of when the task was synced
    protected function casts(): array
    {
        return ['synced_at' => 'datetime'];
    }
    // added the function which scopes unsynced tasks
    public function scopeUnsynced($query)
    {
        return $query->whereNull('synced_at');
    }
}
