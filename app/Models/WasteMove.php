<?php

namespace App\Models;

use App\Enums\WasteMoveState;
use App\Enums\WasteMoveType;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'date',
    'type',
    'category_id',
    'branch_id',
    'quantity',
    'valid_qty',
    'state',
    'waste_picking_id',
    'purchase_transaction_item_id',
    'sale_transaction_item_id',
])]
class WasteMove extends Model
{
    /** @use HasFactory<\Database\Factories\WasteMoveFactory> */
    use HasFactory;

    protected $table = 'waste_moves';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date' => 'datetime',
            'type' => WasteMoveType::class,
            'state' => WasteMoveState::class,
            'quantity' => 'decimal:2',
            'valid_qty' => 'decimal:2',
        ];
    }

    /**
     * Get the waste category that owns the move.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(WasteCategory::class, 'category_id');
    }

    /**
     * Get the waste picking that owns the move.
     */
    public function wastePicking(): BelongsTo
    {
        return $this->belongsTo(WastePicking::class, 'waste_picking_id');
    }

    /**
     * Set the move state to Done.
     */
    public function actionDone(): void
    {
        $this->state = WasteMoveState::Done;
        $this->save();
    }

    /**
     * Set the move state to Cancel.
     */
    public function actionCancel(): void
    {
        $this->state = WasteMoveState::Cancel;
        $this->save();
    }
}
