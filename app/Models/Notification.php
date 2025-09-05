<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable=['message','status','level'];

    public function advisor(){
        return $this->hasOne(Advisor::class);
    }

    public function trainee(){
        return $this->hasOne(Trainee::class);
    }
}
