<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tank extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $with = ['tank_type', 'location'];

    public function tank_type()
    {
        return $this->belongsTo(Tank_types::class);
    }
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
