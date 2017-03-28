<?php

namespace Milax\Mconsole\Seeds;

use DB;
use Milax\Mconsole\Models\Variable;
use Milax\Mconsole\Contracts\MconsoleSeeder;

class MconsoleVariablesSeeder implements MconsoleSeeder
{
    /**
     * Default options with values to create
     * 
     * @var array
     * @access protected
     */
    protected static $variables = [
        [
            'key' => 'link',
            'value' => '<a href="{{ $href }}" target="{{ $target }}">{{ $text }}</a>',
        ],
        [
            'key' => 'image-left',
            'value' => '<img src="{{ $src }}" class="content-image-left" alt="" />',
        ],
        [
            'key' => 'image-right',
            'value' => '<img src="{{ $src }}" class="content-image-right" alt="" />',
        ],
        [
            'key' => 'image-center',
            'value' => '<img src="{{ $src }}" class="content-image-center" alt="" />',
        ],
        [
            'key' => 'file-container',
            'value' => '<div>{{ $filename }}</div>',
            'description' => 'Display single file',
        ],
        [
            'key' => 'files-container',
            'value' => '<ul>@foreach ($files as $file) <li>@fileById($file->id)</li> @endforeach</ul>',
            'description' => 'Display set of files',
        ],
    ];
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public static function run()
    {
        foreach (self::$variables as $variable) {
            if (Variable::where('key', $variable['key'])->count() == 0) {
                Variable::create($variable);
            }
        }
        return 'Installed ' . __CLASS__ . '.';
    }
}
