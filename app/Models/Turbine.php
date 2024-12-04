<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turbine extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, mixed>
     */
    protected $fillable = [
        'name',
        'x_position_offset',
        'y_position_offset',
    ];

    /**
     * Get the wind farm for the turbine.
     */
    public function windFarm()
    {
        return $this->belongsTo(WindFarm::class);
    }

    /**
     * Get the parts for the turbine.
     */
    public function parts()
    {
        return $this->hasMany(Part::class);
    }
}
