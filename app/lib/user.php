<?php

function logUser($user)
{
    $_SESSION['pseudo'] = $user['pseudo'];
    $_SESSION['id'] = $user['id'];
    $_SESSION['alert'] = $user['alert'];
}

function testInput($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

function testPassword($pass)
{
    if (strlen($pass) < 6 || !preg_match('#(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}#', $pass))
    {
        $_SESSION['flash'] = ["fail" => "Le mot de passe doit contenir au moins:
                - 6 characteres
                - 1 majuscule
                - 1 minuscule
                - 1 chiffre"];
        return False;
    }
    return True;
}
