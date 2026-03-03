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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('location',100);
            $table->enum('branch_type',['main','sub'])->default('sub');//dont really need this just mean first branch as main
            $table->timestamps();

            //check what is joining with this by location, becuase from my knowlegde thier should be little 
            //locatoin maybe under 50 so maybe its not even worth making it indexes
            //same goes for branch_type
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
