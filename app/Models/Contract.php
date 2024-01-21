<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start',
        'finish',
        'content',
        'attachment',
        'customer_id',
        'branch_id',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function elecTasks()
    {
        return $this->hasMany(ElecTask::class, 'contract_id', 'id');
    }

    public function waterTasks()
    {
        return $this->hasMany(WaterTask::class, 'contract_id', 'id');
    }

    public function airTasks()
    {
        return $this->hasMany(AirTask::class, 'contract_id', 'id');
    }
}
