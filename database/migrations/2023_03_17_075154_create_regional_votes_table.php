<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegionalVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regional_votes', function (Blueprint $table) {
            $table->id();
            $table->integer('vote');
            $table->string('regional');
            $table->foreignId('party_id')->constrained('parties');
            $table->foreignId('voter_id')->constrained('voters');
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
        Schema::dropIfExists('regional_votes');
    }
}
