<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Personnels extends Model
{
    use HasFactory;
    protected $table = 'personnels';
    public function roles(): BelongsTo
    {
        return $this->belongsTo(Roles::class);
    }
}
