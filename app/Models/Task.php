<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        // 'name',
        'user_id',
        'type_id',
        'chemistry_id',
        'solution_id',
        'item_id',
        'contract_id',
        'frequency_id',
        'range',
        'note',
    ];

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id', 'id');
    }

    public function chemistry()
    {
        return $this->belongsTo(Chemistry::class, 'chemistry_id', 'id');
    }

    public function solution()
    {
        return $this->belongsTo(Solution::class, 'solution_id', 'id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id', 'id');
    }

    public function frequency()
    {
        return $this->belongsTo(Frequency::class, 'frequency_id', 'id');
    }
}
