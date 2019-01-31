<?php

namespace App\Controller\get;

use Dumb\Dumbee;

/**
 * picture.
 *
 * @param Dumbee $container
 * @param array  $options
 */
class picture
{
	public function __construct(Dumbee $c, array $options)
	{
		$picManager = $c->picture;
		$id = intval($_GET['id']);

		if (!($picManager->picInDb($id)))
		{
			require '../app/controller/error.php';
			error($c, $options);
		}
		array_shift($options['header']);
		$elem = $picManager->getPic($id);
		$comment = $c->comment->getComments($id);
		$options['title2'] = htmlspecialchars($elem['title']);
		$view = 'Picture';
		$main = '/picView.html';
		$options['components'] = [];
		$comments = $comment->fetchAll();
		require __DIR__.'/../../view/template.php';
	}
}
