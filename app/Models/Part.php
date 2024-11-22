<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, mixed>
     */
    protected $fillable = [
        'name',
        'condition_rating',
    ];

    /**
     * Get the turbine for the part.
     */
    public function turbine()
    {
        return $this->belongsTo(Turbine::class);
    }
}
