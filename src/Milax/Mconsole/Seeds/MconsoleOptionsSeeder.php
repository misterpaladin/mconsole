<?php

namespace Milax\Mconsole\Seeds;

use DB;
use Milax\Mconsole\Models\MconsoleOption;
use Milax\Mconsole\Contracts\MconsoleSeeder;

class MconsoleOptionsSeeder implements MconsoleSeeder
{
    /**
     * Default options with values to create
     * 
     * @var array
     * @access protected
     */
    protected static $options = [
        [
            'group' => 'mconsole::settings.options.group.name',
            'label' => 'mconsole::settings.labels.name',
            'key' => 'project_name',
            'value' => 'New Project',
            'rules' => ['required'],
            'type' => 'text',
            'options' => null,
        ],
        [
            'group' => 'mconsole::settings.options.group.name',
            'label' => 'mconsole::settings.labels.url',
            'key' => 'project_url',
            'value' => 'http://milax.com',
            'rules' => ['required', 'url'],
            'type' => 'text',
            'options' => null,
        ],
        [
            'group' => 'mconsole::settings.options.group.name',
            'label' => 'mconsole::settings.labels.notifications',
            'key' => 'notifications',
            'value' => '1',
            'rules' => null,
            'type' => 'select',
            'options' => ['1' => 'mconsole::settings.options.on', '0' => 'mconsole::settings.options.off'],
        ],
        [
            'group' => 'mconsole::settings.options.group.name',
            'label' => 'mconsole::settings.labels.editor',
            'key' => 'textareatype',
            'value' => 'textarea',
            'rules' => null,
            'type' => 'select',
            'options' => ['textarea' => 'mconsole::settings.options.textarea', 'ckeditor' => 'mconsole::settings.options.ckeditor', 'codemirror' => 'mconsole::settings.options.codemirror'],
        ],
        [
            'group' => 'mconsole::settings.options.group.name',
            'label' => 'mconsole::settings.labels.editor',
            'key' => 'textareatype',
            'value' => 'textarea',
            'rules' => null,
            'type' => 'select',
            'options' => ['textarea' => 'mconsole::settings.options.textarea', 'ckeditor' => 'mconsole::settings.options.ckeditor', 'codemirror' => 'mconsole::settings.options.codemirror'],
        ],
        [
            'group' => 'mconsole::settings.options.group.name',
            'label' => 'mconsole::settings.labels.editorlinenumbers',
            'key' => 'editorlinenumbers',
            'value' => '1',
            'rules' => null,
            'type' => 'select',
            'options' => ['1' => 'mconsole::settings.options.on', '0' => 'mconsole::settings.options.off'],
        ],
        [
            'group' => 'mconsole::settings.options.group.name',
            'label' => 'mconsole::settings.labels.editorlinewrap',
            'key' => 'editorlinewrap',
            'value' => '1',
            'rules' => null,
            'type' => 'select',
            'options' => ['1' => 'mconsole::settings.options.on', '0' => 'mconsole::settings.options.off'],
        ],
        [
            'group' => 'mconsole::settings.options.group.name',
            'label' => 'mconsole::settings.labels.editorsmartindent',
            'key' => 'editorsmartindent',
            'value' => '1',
            'rules' => null,
            'type' => 'select',
            'options' => ['1' => 'mconsole::settings.options.on', '0' => 'mconsole::settings.options.off'],
        ],
        [
            'group' => 'mconsole::settings.options.group.name',
            'label' => 'mconsole::settings.labels.editortabsize',
            'key' => 'editortabsize',
            'value' => '4',
            'rules' => null,
            'type' => 'select',
            'options' => ['2' => '2', '4' => '4'],
        ],
        [
            'group' => 'mconsole::settings.options.group.name',
            'label' => 'mconsole::settings.labels.editredirect',
            'key' => 'editredirect',
            'value' => '1',
            'rules' => null,
            'type' => 'select',
            'options' => ['1' => 'mconsole::settings.options.on', '0' => 'mconsole::settings.options.off'],
        ],
        [
            'group' => 'mconsole::settings.options.group.site',
            'label' => 'mconsole::settings.labels.defaultheading',
            'key' => 'defaultheading',
            'value' => null,
            'rules' => null,
            'type' => 'text',
            'options' => null,
        ],
        [
            'group' => 'mconsole::settings.options.group.site',
            'label' => 'mconsole::settings.labels.indexing',
            'key' => 'indexing',
            'value' => '1',
            'rules' => null,
            'type' => 'select',
            'options' => ['1' => 'mconsole::settings.options.on', '0' => 'mconsole::settings.options.off'],
        ],
        [
            'group' => 'mconsole::settings.options.group.site',
            'label' => 'mconsole::settings.labels.adminemail',
            'key' => 'adminemail',
            'value' => null,
            'rules' => ['email'],
            'type' => 'text',
            'options' => null,
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
