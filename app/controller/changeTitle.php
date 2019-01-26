<?php

function changeTitle($c)
{
	$id = intval($_POST['id']);
	$title = $_POST['title'];
	$picManager = $c->picture;
	if ($picManager->picInDb($id) && strlen($title) < 30)
		echo $picManager->changeTitle($id, $title);
}
