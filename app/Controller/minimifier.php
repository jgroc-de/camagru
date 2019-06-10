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

    public function get()
    {
    }

    public function bomb(array $options = null)
    {
		$content = '';
        $template = $_GET['template'];
		if ($template !== 'main') {
			$destFile = $this->js($template, $content);
		} else {
			$destFile = $this->index($template, $content);
		}
        $content = str_replace(["\t", "\n"], "", $content);
        echo (file_put_contents($destFile, $content));
    }

	private function js ($template, &$content): string {
		$htmlName = __DIR__."/../View/components/". $template . ".html";
		$destFile =  __DIR__."/../../public/js/app/View/". $template . ".js";
		$content = 'export let template = \'' . file_get_contents($htmlName) . '\'';

		return $destFile;
	}

	private function index ($template, &$content): string {
		$destFile = __DIR__ . '/../../public/index.html';
		ob_start();
		require __DIR__.'/../View/template.html';
		$content = ob_get_contents(); 
		ob_end_clean();

		return $destFile;
	}
}
