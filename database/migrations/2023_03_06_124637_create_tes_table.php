<?php

        
use Illuminate\Database\Migrations\Migration;
        
use Illuminate\Database\Schema\Blueprint;
        
use Illuminate\Support\Facades\Schema;
        

class create_tes_table extends Migration
{
            
    public function up()
    {
                
        Schema::create('tes', function (Blueprint $table) {
                    
            $table->bigIncrements('id');
                    
$table->string('name', 111)->nullable();
$table->unsignedBigInteger('user_id')->nullable();
$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
$table->timestamps();
        });
                    
    }
                    

    public function down()
    {
                        
        Schema::dropIfExists('tes');
                        
    }
                        
}