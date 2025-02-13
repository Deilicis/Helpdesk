<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProblemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('problems', function (Blueprint $table) {
            $table->string('editor')->after('epasts')->nullable();
            $table->enum('status', ['open', 'procesa', 'closed'])->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('problems', function (Blueprint $table) {
            $table->dropColumn('editor');
            $table->string('status')->change();
        });
    }
}