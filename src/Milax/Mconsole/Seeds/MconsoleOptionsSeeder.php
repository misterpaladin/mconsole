<?php

namespace Milax\Mconsole\Seeds;

use DB;

class MconsoleOptionsSeeder
{
    
    /**
     * Table name for options
     * 
     * (default value: 'mconsole_options')
     * 
     * @var string
     * @access protected
     */
    protected static $table = 'mconsole_options';
    
    /**
     * Default options with values to create
     * 
     * @var array
     * @access protected
     */
    protected static $options = [
        'project_name' => 'New Project',
    ];
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public static function run()
    {
        collect(self::$options)->each(function ($value, $key) {
            if (DB::table(self::$table)->where('key', $key)->count() == 0) {
                DB::table(self::$table)->insert([
                    'key' => $key,
                    'value' => $value,
                ]);
            }
        });
        return 'Installed ' . __CLASS__ . '.';
    }
}
