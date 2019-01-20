<?php

function error($c, $error, $options)
{
	header("HTTP/1.1 ".$error['error']['code']." ".$error['error']['message']);
	$components = [
		'/common/about.php',
		'/common/contact.php'
	];
	$header = [
		'/common/error.php',
	];
	require __DIR__.'/../view/template.php';
}
