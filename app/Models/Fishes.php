<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Fishes extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = ['id'];
    protected $dates = ['date_out']; 
    protected $with = ['tank', 'supplier', 'status', 'fish_type', 'size', 'fish_histori'];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function tank()
    {
        return $this->belongsTo(Tank::class);
    }
    public function fish_type()
    {
        return $this->belongsTo(Fish_type::class);
    }
    public function size()
    {
        return $this->belongsTo(Size::class);
    }
    public function fish_histori()
    {
        return $this->belongsTo(Fish_histories::class);
    }

    public function additional_costs()
    {
        return $this->hasMany('App\Models\AdditionalCost','fish_id','id');
    }


    // public function scopeFilter($query, array $filter)
    // {

    //     $query->when($filter['search'] ?? false, function ($query, $search) {

    //         return $query->where('code', 'like', '%' . strtoupper($search) . '%');
    //     });

    //     $query->when(
    //         $filter['location'] ?? false,
    //         fn ($query, $location) =>
    //         $query->whereHas(
    //             'tank',
    //             fn ($query) =>
    //             $query->where('location_id', $location)
    //         )
    //     );
    //     $query->when(
    //         $filter['no_tank'] ?? false,
    //         fn ($query, $tank) =>
    //         $query->whereHas(
    //             'tank',
    //             fn ($query) =>
    //             $query->where('id', $tank)
    //         )
    //     );
    // }
}
