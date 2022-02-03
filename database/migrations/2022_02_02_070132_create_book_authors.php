<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookAuthors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_authors', function (Blueprint $table) {
            $table->unsignedBigInteger('author_id');
            $table->foreign('author_id')->references('id')->on('authors')->onDelete('cascade');;
            $table->unsignedBigInteger('book_id');
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_authors');
    }
}
