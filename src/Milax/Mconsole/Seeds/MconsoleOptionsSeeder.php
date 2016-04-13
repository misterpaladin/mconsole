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
            'group' => 'settings.options.group.name',
            'label' => 'settings.labels.name',
            'key' => 'project_name',
            'value' => 'New Project',
            'type' => 'text',
            'rules' => ['required'],
        ],
        [
            'group' => 'settings.options.group.name',
            'label' => 'settings.labels.url',
            'key' => 'project_url',
            'value' => 'http://milax.com',
            'type' => 'text',
            'rules' => ['required', 'url'],
        ],
        [
            'group' => 'settings.options.group.name',
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
        app('API')->options->install(self::$options);
        return 'Installed ' . __CLASS__ . '.';
    }
}
