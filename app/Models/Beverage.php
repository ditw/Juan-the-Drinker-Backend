<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Beverage extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'beverages'; 

    /**
     * Get the stocks associated with the beverage.
     */
    public function stock(): HasOne
    {
        return $this->HasOne(Stock::class);
    }     
}
