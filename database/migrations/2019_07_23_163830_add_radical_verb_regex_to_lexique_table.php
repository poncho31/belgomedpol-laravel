<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRadicalVerbRegexToLexiqueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lexique', function (Blueprint $table) {
            $table->string("verb_radical")->nullable();
            $table->string("verb_regex")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lexique', function (Blueprint $table) {
            $table->string("verb_radical");
            $table->string("verb_regex");
        });
    }
}
