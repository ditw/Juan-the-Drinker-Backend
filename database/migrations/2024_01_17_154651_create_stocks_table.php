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
        Schema::create('stocks', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->id();
            $table->unsignedBigInteger('bar_id');
            $table->unsignedBigInteger('beverage_id');
            $table->foreign('bar_id')->references('id')->on('bars'); 
            $table->foreign('beverage_id')->references('id')->on('beverages'); 
            $table->float('price', 8, 2); // 32 bit
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable()->useCurrent()->useCurrentOnUpdate();    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stocks', function (Blueprint $table) {
            $table->dropConstrainedForeignId('stocks_bar_id_foreign');
            $table->dropConstrainedForeignId('stocks_beverage_id_foreign');
            Schema::dropIfExists('stocks');
        });
    }
};
