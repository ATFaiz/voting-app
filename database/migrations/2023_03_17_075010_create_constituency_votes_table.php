<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConstituencyVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('constituency_votes', function (Blueprint $table) {
            $table->id();
            $table->integer('vote');
            $table->string('constituency');
            $table->foreignId('voter_id')->constrained('voters');
            $table->foreignId('candidate_id')->constrained('candidates');
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
        Schema::dropIfExists('constituency_votes');
    }
}
