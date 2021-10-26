<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClosuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('closures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('branch_id');
            $table->enum('type', ['diario', 'mensual', 'anual']);
            $table->date('date');
            $table->decimal('entry', 8, 2)->default(0);
            $table->decimal('egress', 8, 2)->default(0);

            $table->foreign('branch_id')->references('id')->on('branches');

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
        Schema::dropIfExists('closures');
    }
}
