<?php

function addComment($c)
{
    $commentManager = $c->comment;
    $userManager = $c->user;

    $commentManager->addComment();
    $response = $commentManager->getCommentByImgId($_POST['id']);
    $user = $userManager->getUserByImgId($_POST['id']);
    if ($user['alert']) {
        $c->mail->sendCommentMail($user);
    }
    return $response;
}
