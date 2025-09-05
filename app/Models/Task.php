<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded=[];



    public function trainees()
    {
        return $this->belongsToMany(Trainee::class, 'training_tasks', 'task_id', 'trainee_id');
    }

    public function isSolvedByTrainee($traineeId): bool
    {
        return $this->trainees()->where('trainee_id', $traineeId)->exists();
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function trainingTasks()
    {
        return $this->hasMany(TrainingTask::class);
    }

    public function advisor()
    {
        return $this->belongsTo(Advisor::class);
    }

}
