<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingTask extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded=[];
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function trainee()
    {
        return $this->belongsTo(Trainee::class);
    }

}
