<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
     use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

     protected $fillable = [
        'id', 'name', 'phone', 'division_id', 'position', 'image'
    ];

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id', 'id');
    }

}
