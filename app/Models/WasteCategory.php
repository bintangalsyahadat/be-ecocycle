<?php

namespace App\Models;

use App\Enums\WasteMoveState;
use App\Enums\WasteMoveType;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'description', 'image_path', 'sales_price', 'purchase_price'])]
class WasteCategory extends Model
{
    /** @use HasFactory<\Database\Factories\WasteCategoryFactory> */
    use HasFactory;

    protected $table = 'waste_categories';

    protected $appends = [
        'stock_move_in',
        'stock_move_out',
        'stock_forecasted',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'sales_price' => 'decimal:2',
            'purchase_price' => 'decimal:2',
        ];
    }

    /**
     * Get the moves for the waste category.
     */
    public function moves(): HasMany
    {
        return $this->hasMany(WasteMove::class, 'category_id');
    }

    /**
     * Sum of completed incoming moves (valid_qty).
     */
    public function getStockMoveInAttribute(): float
    {
        return (float) $this->moves()
            ->where('state', WasteMoveState::Done)
            ->where('type', WasteMoveType::Incoming)
            ->sum('valid_qty');
    }

    /**
     * Sum of completed outgoing moves (valid_qty).
     */
    public function getStockMoveOutAttribute(): float
    {
        return (float) $this->moves()
            ->where('state', WasteMoveState::Done)
            ->where('type', WasteMoveType::Outgoing)
            ->sum('valid_qty');
    }

    /**
     * Net stock: (move_in - move_out) + sum of forecasted incoming valid_qty minus forecasted outgoing valid_qty.
     */
    public function getStockForecastedAttribute(): float
    {
        $moveIn = (float) $this->getStockMoveInAttribute();
        $moveOut = (float) $this->getStockMoveOutAttribute();

        $forecastedIn = (float) $this->moves()
            ->where('state', WasteMoveState::Forecasted)
            ->where('type', WasteMoveType::Incoming)
            ->sum('valid_qty');

        $forecastedOut = (float) $this->moves()
            ->where('state', WasteMoveState::Forecasted)
            ->where('type', WasteMoveType::Outgoing)
            ->sum('valid_qty');

        return ($moveIn - $moveOut) + ($forecastedIn - $forecastedOut);
    }

    /**
     * Get stock forecast for a specific branch.
     *
     * @return array{qty_forecasted: float, branch_id: int}
     */
    public function getStock(int $branchId): array
    {
        $incoming = (float) $this->moves()
            ->where('branch_id', $branchId)
            ->where('type', WasteMoveType::Incoming)
            ->sum('valid_qty');

        $outgoing = (float) $this->moves()
            ->where('branch_id', $branchId)
            ->where('type', WasteMoveType::Outgoing)
            ->sum('valid_qty');

        return [
            'qty_forecasted' => $incoming - $outgoing,
            'branch_id' => $branchId,
        ];
    }
}
