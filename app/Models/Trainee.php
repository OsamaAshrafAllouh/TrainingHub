<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Trainee extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function notification()
    {
        return $this->belongsTo(Notification::class, 'notification_id');
    }

    public function programs()
    {
        return $this->belongsToMany(Program::class, 'training_programs');
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'training_tasks', 'trainee_id', 'task_id');
    }
    public function meetings()
    {
        return $this->hasMany(MeetingRequest::class);
    }

    public function paymentInformation()
    {
        return $this->hasOne(PaymentInformation::class);
    }


}
