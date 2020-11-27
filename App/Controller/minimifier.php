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
    /** @var array */
    public const TEMPLATES = [
        'camagru',
        'myPictures',
        'myPicture',
        'pictures',
        'shot',
        'picture',
        'comment',
        'filter',
    ];

    /** @var string */
    private $content;

    public function get(Request $request): void
    {
    }

    public function bomb(): string
    {
        $this->minimifyHtml($this->toIndex());

        return '';
    }

    private function minimifyHtml(string $destFile): void
    {
        $this->content = str_replace(["\t", "\n"], '', $this->content);
        echo file_put_contents($destFile, $this->content).';';
    }

    private function toIndex(): string
    {
        $destFile = __DIR__.'/../../public/index.html';
        ob_start();
        require __DIR__.'/../View/template.php';
        $this->content = ob_get_contents();
        ob_end_clean();

        return $destFile;
    }
}
