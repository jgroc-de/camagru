<?php

function error($c, $options)
{
	header("HTTP/1.1 ".$options['error']['code']." ".$options['error']['message']);
	$components = [
		'/common/about.php',
		'/common/contact.php'
	];
	$header = [
		'/common/error.php',
	];
	require __DIR__.'/../view/template.php';
}
