<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TarjetaBloque extends Migration
{
    public function up()
    {
        Schema::create('tarjetabloque', function (Blueprint $table) {
            $table->increments('idtarjetabloque');
            $table->integer('idbloque')->unsigned();
            $table->integer('idtarjeta')->unsigned();
            $table->integer('idbimestre')->unsigned();
            
            $table->integer('usercreate')->unsigned();
            $table->foreign('usercreate')->references('id')->on('users')->onUpdate('cascade');
            $table->integer('userupdate');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('tarjetabloque');
    }
}
