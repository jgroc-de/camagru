<?php

function logout()
{
	echo 'Cya '.$_SESSION['pseudo'].'!';
	session_unset();
	session_destroy();
}
