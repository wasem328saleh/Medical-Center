<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalservicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicalservices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('typeService');
        $table->text('note');
        $table->string('isAcceptance');
        $table->text('descriptionAcceptance')->nullable();
        $table->foreignId('patient_id')->references('id')->on('patients')->cascadeOnDelete();
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
        Schema::dropIfExists('medicalservices');
    }
}
