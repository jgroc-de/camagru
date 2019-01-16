<?php

require __DIR__.'/../lib/user.php';

function login($c, $options)
{
    $options['login'] = true;
    $target = "index.php?action=login";

    if ($_SERVER['REQUEST_METHOD'] === "POST")
    {
        $pseudo = testInput($_POST['pseudo']);
        $passwd = testInput($_POST['passwd']);
        if ($pseudo && $passwd)
        {
            $userManager = $c->user;
            if ($userManager->checkLogin($pseudo, $passwd))
            {
                logUser($userManager->getUser($pseudo));
                $target = (isset($_GET['action2']))? '?action=' . $_GET['action2']:'';
                header('Location: index.php' . $target);
				return ;
            }
        }
	}
	$view = 'LogIN';
	$main = '/loginView.html';
	require __DIR__.'/../view/template.php';
}
