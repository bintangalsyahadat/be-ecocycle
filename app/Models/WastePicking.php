<?php

namespace App\Models;

use App\Enums\WastePickingState;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'name',
    'partner_id',
    'date',
    'branch_id',
    'delivery_method_id',
    'state',
    'purchase_transaction_id',
    'sale_transaction_id',
])]
class WastePicking extends Model
{
    /** @use HasFactory<\Database\Factories\WastePickingFactory> */
    use HasFactory;

    protected $table = 'waste_pickings';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date' => 'datetime',
            'state' => WastePickingState::class,
        ];
    }

    /**
     * Boot the model: auto-confirm on create.
     */
    protected static function booted(): void
    {
        static::created(function (WastePicking $picking) {
            $picking->actionConfirm();
        });
    }

    /**
     * Get the waste moves for the picking.
     */
    public function wasteMoves(): HasMany
    {
        return $this->hasMany(WasteMove::class, 'waste_picking_id');
    }

    /**
     * Get the partner for the picking.
     */
    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class, 'partner_id');
    }

    /**
     * Get the branch for the picking.
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    /**
     * Get the delivery method for the picking.
     */
    public function deliveryMethod(): BelongsTo
    {
        return $this->belongsTo(DeliveryMethod::class, 'delivery_method_id');
    }

    /**
     * Confirm the picking: draft → confirm.
     * Generates a name if empty using format {IN/OUT}{year}{4-digit-seq}.
     */
    public function actionConfirm(): void
    {
        if ($this->state !== WastePickingState::Draft) {
            return;
        }

        $this->state = WastePickingState::Confirm;

        if (empty($this->name)) {
            $direction = $this->purchase_transaction_id ? 'IN' : 'OUT';
            $year = now()->year;
            $seq = str_pad((int) WastePicking::max('id') + 1, 4, '0', STR_PAD_LEFT);
            $this->name = "{$direction}{$year}{$seq}";
        }

        $this->save();
    }

    /**
     * Mark the picking as done: confirm → done, cascades to all waste moves.
     */
    public function actionDone(): void
    {
        if ($this->state !== WastePickingState::Confirm) {
            return;
        }

        $this->state = WastePickingState::Done;
        $this->save();

        foreach ($this->wasteMoves as $move) {
            $move->actionDone();
        }
    }

    /**
     * Cancel the picking: draft or confirm → cancel, cascades to all waste moves.
     */
    public function actionCancel(): void
    {
        if (! in_array($this->state, [WastePickingState::Draft, WastePickingState::Confirm], true)) {
            return;
        }

        $this->state = WastePickingState::Cancel;
        $this->save();

        foreach ($this->wasteMoves as $move) {
            $move->actionCancel();
        }
    }
}
