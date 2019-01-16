<?php

function validation($c)
{
    if (isset($_GET['log'], $_GET['key']))    
    {
        $c->user->checkValidationMail($_GET['log'], $_GET['key']);
    }
	$view = 'Sign UP';
	$main = '/signupView.html';
	require __DIR__.'/../view/template.php';
}
