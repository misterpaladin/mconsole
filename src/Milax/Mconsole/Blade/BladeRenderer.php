<?php

namespace Milax\Mconsole\Blade;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Contracts\View\Factory;

class BladeRenderer
{

    /**
     * @var
     */
    protected $html;

    /**
     * @var array|null
     */
    protected $data;

    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * @var Factory
     */
    protected $view;

    /**
     * @param      $html
     * @param array|null $data
     */
    public function __construct($html, $data = [])
    {
        $this->html = $html;
        $this->data = $data;
        $this->files = app(Filesystem::class);
        $this->view = app('view');
    }

    /**
     * Redner the view
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        $this->saveTemporaryHtml();

        $view = $this->view->file($this->getFilePath(), $this->data);

        //$this->deleteTemporaryHtml();

        return $view;
    }

    /**
     * Save the temporary file.
     */
    protected function saveTemporaryHtml()
    {
        $this->files->put($this->getFileName(), $this->html);
    }

    /**
     * Get the temp file name.
     *
     * @return string
     */
    protected function getFileName()
    {
        return md5($this->html) . '.blade.php';
    }

    /**
     * Get the temp file path.
     *
     * @return string
     */
    protected function getFilePath()
    {
        return storage_path('app/' . $this->getFileName());
    }

    /**
     * Delete the temporary file
     */
    protected function deleteTemporaryHtml()
    {
        $this->files->delete($this->getFileName());
    }
}
