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
	'/logout',
    '/camagru',
    '/addComment',
    '/addLike',
    '/changeTitle',
    '/createPic',
    '/deletePic',
    '/settings',
]);
