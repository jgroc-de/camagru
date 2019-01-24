<?php

require_once __DIR__.'/../lib/user.php';

function getSettings($c, $options)
{
	$response['code'] = 200;
	$response['settings'] = $c->user->getUserSettings($_SESSION['pseudo']);
	return $response;
}
