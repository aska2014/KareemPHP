<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('posts', function(Blueprint $table)
		{
            $table->engine = 'InnoDB';
			$table->increments('id');

            $table->string('title');
            $table->text('description');
            $table->string('tags');
            $table->string('slug');

            $table->smallInteger('difficulty')->default(\Blog\Post\Post::BEGINNER);
            $table->smallInteger('state')->default(\Blog\Post\Post::DRAFT);

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');

            $table->integer('copy_of_id')->unsigned()->nullable();
            $table->foreign('copy_of_id')->references('id')->on('posts')->onDelete('CASCADE');

            $table->softDeletes();
            $table->dateTime('posted_at');
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
		Schema::drop('posts');
	}

}
