<?php

declare(strict_types=1);

namespace App\Controller;

use Dumb\Patronus;

/**
 * viewFactory
 * provide home view.
 */
class minimifier extends Patronus
{
    private $view;

    private $content = '';

    public function get()
    {
    }

    public function bomb(array $options = null)
    {
        $template = $_GET['template'];
        if ('main' !== $template) {
            $destFile = $this->toJS($template);
        } else {
            $destFile = $this->toIndex($template);
        }
        $this->content = str_replace(["\t", "\n"], '', $this->content);
        echo file_put_contents($destFile, $this->content);
    }

    private function toJS($template): string
    {
        $htmlName = __DIR__.'/../View/components/'.$template.'.html';
        $destFile = __DIR__.'/../../public/js/app/View/'.$template.'.js';
        $this->content = 'export let template = \''.file_get_contents($htmlName).'\'';

        return $destFile;
    }

    private function toIndex($template): string
    {
        $destFile = __DIR__.'/../../public/index.html';
        ob_start();
        require __DIR__.'/../View/template.html';
        $this->content = ob_get_contents();
        ob_end_clean();

        return $destFile;
    }
}
