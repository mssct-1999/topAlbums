<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsCommentaires extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comments',function(Blueprint $table) {
            $table->text('comments');
            $table->string('title');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_album');
            $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('id_album')->references('id')->on('albums');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function($table) {
            $table->dropColumn('comments');
            $table->dropColumn('title');
        });
    }
}
