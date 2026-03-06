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
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();
            $table->string('name',75);
            $table->integer('threshold')->unsigned()->default(10);
                //this feels ilegal in some way, i dont think that the best but it will do for now since 
                //it will apply even if i did not use eloquent
            $table->foreignId('category_id')->nullable()->constrained();
       

            $table->integer('unit_quantity')->unsigned()->nullable();
            //pretty sure i was suppose to remove unit_quantity
            $table->index('name','ingredient_name_index');
            $table->index('category_id','category_id_index');
            
            //lets do it, i will use this actually in filter, but it depends on how much is category if it 
            //exceed 100 record then this is fine,

            //justify this later, if its not good i will just remove it before prod
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredients');
    }
};
