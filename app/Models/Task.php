<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
    ];

    protected $fillable = [
        // 'name',
        'note',
        'type_id',
        'contract_id',
    ];

    public function details()
    {
        return $this->hasMany(TaskDetail::class, 'task_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id', 'id');
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id', 'id');
    }
}
