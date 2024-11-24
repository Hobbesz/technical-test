<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    /**
     * Get the users for the account.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the wind farms for the account.
     */
    public function windFarms()
    {
        return $this->hasMany(WindFarm::class);
    }
}
