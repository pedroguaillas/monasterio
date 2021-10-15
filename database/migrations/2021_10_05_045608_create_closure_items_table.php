<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClosureItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('closure_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('closure_id');
            $table->string('description');
            $table->date('date');
            $table->decimal('debit', 8, 2)->default(0);
            $table->decimal('have', 8, 2)->default(0);

            $table->foreign('closure_id')->references('id')->on('closures');

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
        Schema::dropIfExists('closure_items');
    }
}
