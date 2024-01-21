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
        Schema::create('drinks', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->id();
            $table->unsignedBigInteger('stock_id');
            $table->foreign('stock_id')->references('id')->on('stocks'); 
            $table->unsignedBigInteger('visit_id');
            $table->foreign('visit_id')->references('id')->on('visits'); 
            $table->integer('quantity');
            $table->boolean('happyHour');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable()->useCurrent()->useCurrentOnUpdate();  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('drinks', function (Blueprint $table) {
            $table->dropConstrainedForeignId('drinks_stock_id_foreign');
            $table->dropConstrainedForeignId('drinks_visit_id_foreign');
            Schema::dropIfExists('drinks');
        });
    }
};
