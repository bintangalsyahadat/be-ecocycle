<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'phone', 'email'];

    public function wastePickings(): HasMany
    {
        return $this->hasMany(WastePicking::class, 'partner_id');
    }
}
