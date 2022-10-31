<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Monthly_cost extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $with = ['size'];

    public function size()
    {
        return $this->belongsTo(Size::class);
    }
}
