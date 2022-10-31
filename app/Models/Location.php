<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $with = ['tank_type'];

    public function tank_type()
    {
        return $this->belongsTo(Tank_types::class);
    }
}
