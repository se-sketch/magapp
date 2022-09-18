<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNomenclaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nomenclatures', function (Blueprint $table) {

            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->bigIncrements('id');
            $table->string('name')->nullable(false);
            $table->tinyInteger('active')->nullable(false)->default(0);
            $table->boolean('balance')->nullable(false)->default(true);
            $table->unsignedDecimal('price', 8, 2)->nullable(false)->default(0);

            $table->unsignedDecimal('weight', 10, 3)->nullable(true)->default(0);

            //$table->string('slug')->unique();
            $table->string('slug')->nullable(true);

            $table->string('details')->nullable(true);
            $table->text('description')->nullable(true);

            //$table->string('image')->nullable(true);
           
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nomenclatures');
    }
}
