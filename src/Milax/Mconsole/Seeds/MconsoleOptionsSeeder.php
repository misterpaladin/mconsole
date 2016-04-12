<?php

namespace Milax\Mconsole\Seeds;

use DB;
use Milax\Mconsole\Models\MconsoleOption;

class MconsoleOptionsSeeder
{
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
            'rules' => ['required'],
        ],
        [
            'label' => 'settings.labels.url',
            'key' => 'project_url',
            'value' => 'http://milax.com',
            'type' => 'text',
            'rules' => ['required', 'url'],
        ],
        [
            'label' => 'settings.labels.notifications',
            'key' => 'notifications',
            'value' => '1',
            'type' => 'select',
            'options' => ['1' => 'On', '0' => 'Off'],
        ],
    ];
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public static function run()
    {
        foreach (self::$options as $option) {
            if ($dbOption = MconsoleOption::where('key', $option['key'])->first()) {
                unset($option['value']);
                foreach ($option as $key => $value) {
                    $dbOption->$key = $value;
                }
                $dbOption->save();
            } else {
                MconsoleOption::create($option);
            }
        }
        return 'Installed ' . __CLASS__ . '.';
    }
}
