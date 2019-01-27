<?php

$api->add(
	function($key, $type) {
		$_POST[$key] = htmlspecialchars(stripslashes(trim($_POST[$key])));

		if (!isset($_POST[$key]) || !$_POST[$key]) {
			return (401);
		}
		switch ($type) {
			case 'numeric':
				if (!is_numeric($_POST[$key])) {
					return (401);
				} else {
					$_POST[$key] = intval($_POST[$key]);
				}
				break;
			case 'password':
				if (!preg_match('#(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,256}#', $_POST[$key])) {
					return (401);
				}
				break;
			case 'email':
				if (!preg_match('#^[_A-Za-z0-9-\+]+(\.[_A-Za-z0-9-]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9]+)*(\.[A-Za-z]{2,63})$#', $_POST[$key])) {
					return (401);
				}
				break;
			case'pseudo':
				if (strlen($_POST[$key]) > 30) {
					return (401);
				}
				break;
		}
		return (0);
	},
	[
		'/login' => ['password' => 'password', 'pseudo' => 'pseudo',],
		'/signup' => ['password' => 'password', 'pseudo' => 'pseudo', 'email' => 'email'],
		'/settings' => ['alert' => '', 'pseudo' => 'pseudo', 'email' => 'email'],
		'/addLike' => ['id' => 'numeric',],
		'/addComment' => ['id' => 'numeric', 'comment' => ''],
		'/changeTitle' => ['id' => 'numeric', 'title' => 'pseudo'],
		'/deletePic' => ['url' => '']
		'/reinitPost' => ['pseudo' => 'pseudo']
	]
);

/*$api->add(function($key, $type) {
	if (0)
	{
		return (401);
	}
	return (0);
},
	[
		'/changeTitle' => ['title' => '',],
	]);*/
