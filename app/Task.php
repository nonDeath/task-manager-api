<?php

namespace App;

use App\Model;

class Task extends Model
{
    protected $fillable = [
        'title', 'description', 'due_date', 'created_by', 'assigned_to', 'priority_id'
    ];

    public function priority()
    {
        return $this->belongsTo(\App\Priority::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(\App\User::class, 'created_by');
    }

    public function assignedTo()
    {
        return $this->belongsTo(\App\User::class, 'assigned_to');
    }
}
