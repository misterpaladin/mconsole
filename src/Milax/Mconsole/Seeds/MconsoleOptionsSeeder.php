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
        [
            'label' => 'settings.labels.name',
            'key' => 'project_name',
            'value' => 'New Project',
            'type' => 'text',
        ],
        [
            'label' => 'settings.labels.url',
            'key' => 'project_url',
            'value' => 'http://milax.com',
            'type' => 'text',
        ],
        [
            'label' => 'settings.labels.notifications',
            'key' => 'notifications',
            'value' => '1',
            'type' => 'select',
            'options' => '{"1": "On", "0": "Off"}',
        ],
    ];
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public static function run()
    {
        collect(self::$options)->each(function ($option) {
            if (DB::table(self::$table)->where('key', $option['key'])->count() == 0) {
                DB::table(self::$table)->insert($option);
            } else {
                unset($option['value']);
                DB::table(self::$table)->where('key', $option['key'])->update($option);
            }
        });
        return 'Installed ' . __CLASS__ . '.';
    }
}
