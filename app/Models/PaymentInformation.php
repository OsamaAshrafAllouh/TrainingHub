<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentInformation extends Model
{
    use HasFactory , SoftDeletes;

    protected $guarded=[];

    protected $table = 'payment_informations';

    public function trainee()
    {
        return $this->belongsTo(Trainee::class);
    }

}
