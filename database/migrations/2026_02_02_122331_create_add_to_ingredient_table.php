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
                // if this is table it just mean extension of another table, not new table, like create
        Schema::create('add_to_ingredient', function (Blueprint $table) {
            $table->foreignId('add_ingredient_id')->constrained();
            $table->foreignId('ingredient_id')->constrained();
            $table->foreignId('branch_id')->constrained();
            $table->integer('quantity')->unsigned();
                    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('add_to_ingredient');
    }
};
