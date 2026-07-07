<?php

namespace App\Models;

use App\Enums\DeliveryMethodType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeliveryMethod extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'is_self_service', 'type'];

    protected function casts(): array
    {
        return [
            'is_self_service' => 'boolean',
            'type' => DeliveryMethodType::class,
        ];
    }

    public function wastePickings(): HasMany
    {
        return $this->hasMany(WastePicking::class, 'delivery_method_id');
    }
}
