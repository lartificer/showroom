<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTranslationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('news_translations', function(Blueprint $table)
		{
			$table->increments('id');
            $table->text('title');
            $table->text('content');
            $table->string('slug');
            $table->unsignedInteger('news_id');
            $table->foreign('news_id')
                ->references('id')
                ->on('news')
                ->onDelete('cascade');
            // To fit the ISO 639-1 standards
            $table->char('language', 2);
            $table->softDeletes();
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
		Schema::drop('news_translations');
	}

}
