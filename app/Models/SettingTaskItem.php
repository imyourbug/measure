<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingTaskItem extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
    ];

    protected $fillable = [
        'code',
        'name',
        'unit',
        'kpi',
        'result',
        'image',
        'detail',
        'task_id',
        'item_id',
    ];

    public function task()
    {
        return $this->belongsTo(TaskDetail::class, 'task_id', 'id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }
}
