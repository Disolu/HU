<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Bloque extends Migration
{

    public function up()
    {
        Schema::create('bloque', function (Blueprint $table) {
            $table->increments('idbloque');
            $table->string('nombre');
            
            $table->integer('usercreate')->unsigned();
            $table->foreign('usercreate')->references('id')->on('users')->onUpdate('cascade');
            $table->integer('userupdate');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('bloque');
    }
}
