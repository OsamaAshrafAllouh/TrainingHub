<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MeetingRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded=[];

    public function advisor()
    {
        return $this->belongsTo(Advisor::class);
    }

    public function trainee()
    {
        return $this->belongsTo(Trainee::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
