<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskDetail extends Model
{
    use HasFactory;

    protected $casts = [
        // 'name',
        'plan_date' => 'datetime:d-m-Y',
        'actual_date' => 'datetime:d-m-Y',
        'created_at' => 'datetime:d-m-Y',
    ];

    protected $fillable = [
        // 'name',
        'plan_date',
        'actual_date',
        'time_in',
        'time_out',
        'range',
        'note',
        'task_id',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }
}
