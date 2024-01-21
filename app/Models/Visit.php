<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Visit extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'visits';
    
    /**
     * Get the bar associated with the visit.
     */
    public function bar(): BelongsTo
    {
        return $this->belongsTo(Bar::class);
    }    
    
    /**
     * Get the drinks associated with the visit.
     */
    public function drinks(): HasMany
    {
        return $this->hasMany(Drink::class);
    }       
}
