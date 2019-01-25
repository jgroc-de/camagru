<?php

function picture($c, $options)
{
    $picManager = $c->picture;
	$id = intval($_GET['id']);

    if (!($picManager->picInDb($id))) 
	{
		require '../app/controller/error.php';
		error($this->container, null, $options);
	}
	array_shift($options['header']);
	$elem = $picManager->getPic($id);
	$comment = $c->comment->getComments($id);
	$options['title2'] = htmlspecialchars($elem['title']);
	$options['script'] = "/js/picView.js";
	$view = 'Picture';
	$main = '/picView.html';
	$options['components'] = [];
	require __DIR__.'/../view/template.php';
}
