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
	$header = [
		'/common/header.php',
	];
	if (!isset($_SESSION['pseudo']))
	{
		$header[] = '/form/signupView.html';
		$header[] = '/form/loginView.html';
		$header[] = '/form/reinitView.html';
	}
	else
		$header[] = '/form/settingsView.html';
	$main = '/listPicView.html';
	$view = 'Last Pictures';
	require __DIR__.'/../view/template.php';
}
