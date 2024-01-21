<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('beverages', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->id();
            $table->string('name', 191);
            $table->string('barcode', 191);
            $table->float('alcoholUnit', 8, 2); // 32 bit
            $table->enum('type', ['beer', 'tequila', 'whiskey']);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable()->useCurrent()->useCurrentOnUpdate();    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beverages');
    }
};
