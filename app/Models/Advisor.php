<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Advisor extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded =[];

    public function notification()
    {
        return $this->belongsTo(Notification::class, 'notification_id');
    }

    public function programs()
    {
        return $this->belongsToMany(Program::class);
    }

    public function fields()
    {
        return $this->belongsToMany(Field::class, 'advisor_fields');

    }

    public function meetings()
    {
        return $this->hasMany(MeetingRequest::class);
    }

}
