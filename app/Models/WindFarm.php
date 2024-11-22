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
     * Get the user for the wind farm.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
