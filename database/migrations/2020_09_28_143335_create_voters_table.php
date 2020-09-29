<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voters', function (Blueprint $table) {
            $table->id();
            $table->string('cognome');
            $table->string('nome');
            $table->string('citta_residenza')->nullable();
            $table->string('indirizzo_residenza')->nullable();
            $table->string('cap_residenza')->nullable();
            $table->string('provincia_residenza')->nullable();
            $table->date('data_nascita')->nullable();
            $table->string('citta_nascita')->nullable();
            $table->string('sesso')->nullable();
            $table->string('impiego')->nullable();
            $table->string('telefono_fisso')->nullable();
            $table->string('telefono_cellulare')->nullable();
            $table->string('email')->nullable();
            $table->string('sezione')->nullable();
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
        Schema::dropIfExists('voters');
    }
}
