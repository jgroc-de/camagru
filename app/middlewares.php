<?php

$api->add(function() {
	if (isset($_SESSION['user']))
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
	if (!isset($_SESSION['user']))
	{
		return (403);
	}
	return (0);
},
[
	'/logout',
    '/camagru',
    '/addComment',
    '/addLike',
    '/changeTitle',
    '/createPic',
    '/deletePic',
    '/settings',
]);
