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

$api->add(function() {
	if (!isset($_POST['id']) || !is_numeric($_POST['id']))
	{
		return (401);
	}
	return (0);
},
	[
		'/addLike',
]);
