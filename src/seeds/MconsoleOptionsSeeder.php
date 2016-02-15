<?php

use Illuminate\Database\Seeder;

class MconsoleOptionsSeeder extends Seeder
{
	
	/**
	 * Table name for options
	 * 
	 * (default value: 'mconsole_options')
	 * 
	 * @var string
	 * @access protected
	 */
	protected $table = 'mconsole_options';
	
	/**
	 * Default options with values to create
	 * 
	 * @var array
	 * @access protected
	 */
	protected $options = [
		'project_name' => 'New Project',
	];
	
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		
		collect($this->options)->each(function ($value, $key) {
			if (DB::table($this->table)->where('key', $key)->count() == 0)
				DB::table($this->table)->insert([
					'key' => $key,
					'value' => $value,
				]);
		});
	}
}
