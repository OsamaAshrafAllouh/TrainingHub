<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Password;

class Field extends Model
{
    use HasFactory,SoftDeletes;


    protected $guarded=[];

    public function advisors()
    {
        return $this->belongsToMany(Advisor::class, 'advisor_fields');
    }

    public function programs()
    {
        return $this->hasMany(Program::class);
    }

}
