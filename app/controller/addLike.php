<?php

function addLike($c)
{
    $picManager = $c->picture;

    if (isset($_GET['q']) && ($picManager->picInDb($_GET['q'])))
        echo $picManager->addlike($_GET['q']);
}
