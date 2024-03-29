<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = ['project_id', 'name', 'due_date'];

    public function project() 
    {
        return $this->belongsTo(\App\Models\Project::class);
    }

    public function getPriorityAttribute()
    {
        return ($this->due_date) ? 'High' : 'Low';
    }
}
