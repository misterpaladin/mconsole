<?php

namespace Milax\Mconsole\Seeds;

use DB;
use Milax\Mconsole\Contracts\MconsoleSeeder;

class MconsoleUploadsPresetsSeeder implements MconsoleSeeder
{
    /**
     * Default upload presets to create
     * 
     * @var array
     * @access public
     */
    public static $presets = [
        [
            'key' => 'original_document',
            'type' => \MconsoleUploadType::Document,
            'name' => 'Original document',
            'path' => 'original/documents',
            'extensions' => ['webp', 'svg', 'jpg', 'jpeg', 'png', 'gif', '7z', 'rar', 'zip', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'rtf', 'txt', 'pps', 'ppt', 'pptx', 'pdf'],
        ],
    ];
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public static function run()
    {
        app('API')->presets->install(self::$presets);

        return 'Installed ' . __CLASS__ . '.';
    }
}
