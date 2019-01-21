<?php

require_once __DIR__.'/../lib/user.php';

function getSettings($c, $options)
{
	echo json_encode($c->user->getUserSettings($_SESSION['pseudo']));
}
