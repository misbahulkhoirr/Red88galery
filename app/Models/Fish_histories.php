<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fish_histories extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $with = ['status', 'size'];
    public function size()
    {
        return $this->belongsTo(Size::class);
    }
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
