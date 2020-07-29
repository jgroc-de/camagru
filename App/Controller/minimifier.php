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
    private $content = '';

    private $templates = [
        'camagru',
        'myPictures',
        'myPicture',
        'pictures',
        'shot',
        'picture',
        'comment',
        'filter',
    ];

    public function __construct(array $container, string $method, int $code = 200)
    {
        $this->method = $method;
        $this->code = $code;
    }

    public function get()
    {
    }

    public function bomb(): string
    {
        foreach ($this->templates as $template) {
            $this->minimifyHtml($this->toJS($template));
        }
        $this->minimifyHtml($this->toIndex(true));
        $this->minimifyHtml($this->toIndex(false));

        return "";
    }

    private function minimifyHtml($destFile)
    {
        $this->content = str_replace(["\t", "\n"], '', $this->content);
        echo file_put_contents($destFile, $this->content).';';
    }

    private function toJS($template): string
    {
        $htmlName = __DIR__.'/../View/components/'.$template.'.html';
        $destFile = __DIR__.'/../../public/js/app/View/'.$template.'.js';
        $this->content = 'export let template = \''.file_get_contents($htmlName).'\'';

        return $destFile;
    }

    private function toIndex($index = true): string
    {
        if ($index) {
            $destFile = __DIR__.'/../../public/index.html';
        } else {
            $destFile = __DIR__.'/../../offline.html';
        }
        ob_start();
        require __DIR__.'/../View/template.html';
        $this->content = ob_get_contents();
        ob_end_clean();

        return $destFile;
    }
}
