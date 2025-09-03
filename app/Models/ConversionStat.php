<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConversionStat extends Model
{

    use HasFactory;

    protected $fillable = ['integer_value', 'roman', 'conversions_count', 'last_converted_at'];
    protected $casts = ['last_converted_at' => 'datetime'];

}
