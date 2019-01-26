<?php

$api->add(function() {
	if (isset($_SESSION['pseudo']))
	{
		return (401);
	}
	return (0);
},
[
	'/login',
	'/signup',
]);

$api->add(function() {
	if (!isset($_SESSION['pseudo']))
	{
		return (403);
	}
	return (0);
},
[
	'/getSettings',
    '/password',
	'/logout',
    '/camagru',
    '/addComment',
    '/addLike',
    '/changeTitle',
    '/createPic',
    '/deletePic',
    '/settings',
]);

$api->add(function() {
	if (!isset($_GET['id']) || !is_numeric($_GET['id']))
	{
		return (401);
	}
	return (0);
},
	[
		'/picture',
]);

//pour les formulaires
$api->add(function($key, $type) {
	if (!isset($_POST[$key]) || !$_POST[$key])
	{
		return (401);
	}
	if ($type === 'numeric')
	{
		if (!is_numeric($_POST[$key]))
		{
			return (401);
		}
	}
	else if ($type === '')
	{
		if ($_POST[$key] == '')
		{
			return (401);
		}
	}
	return (0);
},
	[
		'/login' => ['password' => '', 'pseudo' => '',],
		'/addLike' => ['id' => 'numeric',],
		'/addComment' => ['id' => 'numeric', 'comment' => ''],
		'/changeTitle' => ['id' => 'numeric', 'title' => ''],
]);

$api->add(function($key, $type) {
	if (strlen($_POST[$key]) >= 30)
	{
		return (401);
	}
	return (0);
},
	[
		'/changeTitle' => ['title' => '',],
		'/login' => ['pseudo' => '',],
]);
