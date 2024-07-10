<?php

namespace App\Models;

use App\Models\Personnels;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Roles extends Model
{
    use HasFactory;
    protected $table = 'roles';

    public function personnels():HasMany
    {
        return $this->hasMany(Personnels::class);
    }
}
