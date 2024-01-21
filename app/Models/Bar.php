<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bar extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bars';
    
    /**
     * Get the stocks associated with the bar.
     */
    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    } 
 
    /**
     * Get the visits associated with the bar.
     */
    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class);
    }     
}
