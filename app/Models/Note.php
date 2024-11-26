<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, mixed>
     */
    protected $fillable = [
        'text',
    ];

    /**
     * Get the part for the note.
     */
    public function part()
    {
        return $this->belongsTo(Part::class);
    }
}
