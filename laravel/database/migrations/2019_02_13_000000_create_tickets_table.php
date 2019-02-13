<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            
            $table->integer('TicketID');
            
            $table->integer('CategoryID');
            $table->integer('CustomerID');
            $table->string('CustomerName');
            $table->string('CustomerEmail');
            $table->date('DateCreate');
            $table->date('DateUpdate');
            $table->integer('PriorityScore');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
