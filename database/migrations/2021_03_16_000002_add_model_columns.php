<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('translated_com_orders', function (Blueprint $table) {
            $table->after('id', function ($table) {
                $table->morphs('model');
                $table->string('column')->nullable()->default(null);
                $table->json('flex')->nullable()->default(null);
            });
            $table->after('total', function (Blueprint $table) {
                $table->unsignedBigInteger('confirmed_by')->nullable()->default(null);
                $table->datetime('confirmed_at')->nullable()->default(null);
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('translated_com_orders', function (Blueprint $table) {
            $table->dropColumn('model_type');
            $table->dropColumn('model_id');
            $table->dropColumn('column');
            $table->dropColumn('flex');
            $table->dropColumn('confirmed_by');
            $table->dropColumn('confirmed_at');
        });
    }
};
