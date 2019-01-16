<?php

function picture($c, $options)
{
    $picManager = $c->picture;

    $id = isset($_GET['id'])? $_GET['id']: 0;
    if (!($picManager->picInDb($id))) 
		header('Location: index.php');
    else
    {
		$elem = $picManager->getPic($id);
		$comment = $c->comment->getComments($id);
        $options['title2'] = htmlspecialchars($elem['title']);
		$options['script'] = "public/js/picView.js";
		$view = 'Picture';
		$main = '/picView.html';
		require __DIR__.'/../view/template.php';
	}
}
