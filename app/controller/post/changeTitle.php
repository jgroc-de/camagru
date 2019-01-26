<?php

function changeTitle($c)
{
	$id = $_POST['id'];
	$title = $_POST['title'];
	$picManager = $c->picture;
	if ($picManager->picInDb($id))
		echo $picManager->changeTitle($id, $title);
}
