<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagShortLinkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tag_short_link', function (Blueprint $table) {
            $table->integer('short_link_id')->unsigned();
            $table->integer('tag_id')->unsigned();
            $table->foreign('short_link_id')->references('id')->on('short_links')
                ->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tag_short_link');
    }
}
