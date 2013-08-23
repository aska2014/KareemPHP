<?php

use Illuminate\Database\Migrations\Migration;

class AddShowInMenuToPages extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('pages', function($table)
        {
            $table->boolean('show_in_menu');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('pages', function($table)
        {
            $table->dropColumn('show_in_menu');
        });
	}

}