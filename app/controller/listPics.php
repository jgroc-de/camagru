<?php

function listpics($c, $options)
{
    $picManager = $c->picture;
	$count = $picManager->countPics();
    $start = isset($_GET['start']) ? $_GET['start'] : 0;
	$count = $count[0] / 6;
    if(!is_numeric($start) || $start > $count)
		$start = 0;
    $pics = $picManager->getPics($start * 6);
	$components = [
		'/common/about.php',
		'/common/contact.php'
	];
	$header = ['/common/header.php'];
	$main = '/listPicView.html';
	$view = 'Last Pictures';
	require __DIR__.'/../view/template.php';
}
