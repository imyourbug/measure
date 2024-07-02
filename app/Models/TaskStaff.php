<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskStaff extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'position',
        'tel',
        'identification',
        'task_id',
        'staff_id',
    ];

    public function task()
    {
        return $this->belongsTo(TaskDetail::class, 'task_id', 'id');
    }

    public function staff()
    {
        return $this->belongsTo(InfoUser::class, 'staff_id', 'id');
    }
}
