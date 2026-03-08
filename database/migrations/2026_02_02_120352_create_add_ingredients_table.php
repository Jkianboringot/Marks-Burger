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
        Schema::create('add_ingredients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained();
            $table->index('branch_id','add_ingredient_branch_id_index');//even if its small its essential for faster query and filter
            //branch_id wont be big again, no random indexes 
            //maybe when we expand but for now not needed since mb only has about 10 branch
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('add_ingredients');
    }
};
