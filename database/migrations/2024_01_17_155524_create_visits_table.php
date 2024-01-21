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
        Schema::create('visits', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->id();
            $table->unsignedBigInteger('bar_id');
            $table->foreign('bar_id')->references('id')->on('bars');
            $table->timestamp('visitedOn')->default(DB::raw('CURRENT_TIMESTAMP')); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visits', function (Blueprint $table) {
            $table->dropConstrainedForeignId('visits_bar_id_foreign');
            Schema::dropIfExists('visits');
        });
    }
};
