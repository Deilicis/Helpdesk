<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewProblemToProblemsTable extends Migration
{
    public function up()
    {
        Schema::table('problems', function (Blueprint $table) {
            $table->string('nozare')->after('id'); // Adjust the column type and name as needed
        });
    }

    public function down()
    {
        Schema::table('problems', function (Blueprint $table) {
            $table->dropColumn('nozare');
        });
    }
}