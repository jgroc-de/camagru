<?php

function addComment($c)
{
	$commentManager = $c->comment;
	$userManager = $c->user;

	$commentManager->addComment();
	$com = $commentManager->getCommentByImgId($_POST['id']);
	$user = $userManager->getUserByImgId($_POST['id']);
	echo "<h3>" . htmlspecialchars($com['pseudo']) ."</h3>
		<p>le " . htmlspecialchars($com['date2']) . "<br>" .
		htmlspecialchars($com['content']) . "</p>";
	if ($user['alert'])
	{
		$c->mail->sendCommentMail($user);
	}
}
