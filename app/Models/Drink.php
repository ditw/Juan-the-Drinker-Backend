<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Drink extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'drinks';   
    
    /**
     * Get the stocks associated with the drink.
     */
    public function stock(): BelongsTo
    {
        return $this->BelongsTo(Stock::class);
    }   
    
    /**
     * Get the visit associated with the drink.
     */
    public function visit(): BelongsTo
    {
        return $this->belongsTo(Visit::class);
    }     
}
