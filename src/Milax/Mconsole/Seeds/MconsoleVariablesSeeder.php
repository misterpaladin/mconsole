<?php

namespace Milax\Mconsole\Seeds;

use DB;
use Milax\Mconsole\Models\Variable;

class MconsoleVariablesSeeder
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
            'key' => 'copyright',
            'value' => '<a href="http://www.milax.com" target="_blank">Milax</a>',
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
