<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTranslatedComTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('translated_com_orders')) {
            Schema::create('translated_com_orders', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('pid')->nullable()->default(null);
                $table->string('s')->nullable()->default(null);
                $table->text('t')->nullable()->default(null);
                $table->text('of')->nullable()->default(null);
                $table->string('f')->nullable()->default(null);
                $table->string('sandbox')->nullable()->default(null);
                $table->text('text')->nullable()->default(null);
                $table->string('pn')->nullable()->default(null);
                $table->string('jt')->nullable()->default(null);
                $table->integer('w')->nullable()->default(null);
                $table->string('df')->nullable()->default(null);
                $table->string('tm')->nullable()->default(null);
                $table->string('endpoint')->nullable()->default(null);
                $table->string('subject')->nullable()->default(null);
                $table->text('instructions')->nullable()->default(null);
                $table->integer('code')->nullable()->default(null);
                $table->string('message')->nullable()->default(null);
                $table->datetime('delivery_date')->nullable()->default(null);
                $table->integer('words')->nullable()->default(null);
                $table->float('total')->nullable()->default(null);

                $table->timestamps();
            });
        }

        if (!Schema::hasTable('translated_com_confirmation')) {
            Schema::create('translated_com_confirmation', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('pid')->nullable()->default(null);
                $table->text('of')->nullable()->default(null);
                $table->string('f')->nullable()->default(null);
                $table->string('sandbox')->nullable()->default(null);
                $table->boolean('c')->nullable()->default(null);
                $table->integer('code')->nullable()->default(null);
                $table->string('message')->nullable()->default(null);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('translated_com_results')) {
            Schema::create('translated_com_results', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('pid')->nullable()->default(null);
                $table->text('text');
                $table->text('t');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('translated_com_orders')) {
            Schema::dropIfExists('translated_com_orders');
        }
        if (Schema::hasTable('translated_com_confirmation')) {
            Schema::dropIfExists('translated_com_confirmation');
        }
        if (Schema::hasTable('translated_com_results')) {
            Schema::dropIfExists('translated_com_results');
        }
    }
}
