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
            $table->string('fullname');
            $table->date('dob');
            $table->string('address');
            $table->string('postcode');
            $table->string('regional');
            $table->string('constituency');
            $table->foreignId('boundary_id')->constrained('boundaries')->nullable()->default(null);
            $table->foreignId('user_id')->constrained('users');
            $table->timestamp('expires_at')->nullable();
            $table->boolean('has_voted')->default(false);
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
