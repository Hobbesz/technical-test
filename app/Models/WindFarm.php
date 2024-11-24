<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WindFarm extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, mixed>
     */
    protected $fillable = [
        'name',
        'longitude',
        'latitude',
    ];

    /**
     * Get the account for the wind farm.
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Get the turbines for the wind farm.
     */
    public function turbines()
    {
        return $this->hasMany(Turbine::class);
    }
}
