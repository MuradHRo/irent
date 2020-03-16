<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionSelectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_selection', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('selection_id')->unsigned();
            $table->bigInteger('question_id')->unsigned();

            $table->foreign('selection_id')->references('id')->on('selections')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_selection');
    }
}
