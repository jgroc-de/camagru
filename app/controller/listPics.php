<?php

function listpics(Dumbee $container, array $options)
{
    $picManager = $container->picture;
	$count = $picManager->countPics();
    $start = isset($_GET['start']) ? $_GET['start'] : 0;
	$count = $count[0] / 6;
    if(!is_numeric($start) || $start > $count)
		$start = 0;
    $pics = $picManager->getPics($start * 6);
	$components = $options['components'];
	$header = [
		'/common/header.php',
	];
	if (!isset($_SESSION['pseudo']))
	{
		$header[] = '/form/loginView.html';
		$header[] = '/form/reinitView.html';
	}
	else
		$header[] = '/form/settingsView.html';
	$main = '/listPicView.html';
	$view = 'Last Pictures';
	require __DIR__.'/../view/template.php';
}
