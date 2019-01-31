<?php

use Dumb\Dumbee;

/**
 * changeTitle.
 *
 * @param Dumbee $c
 * @param array  $options
 */
function changeTitle(Dumbee $c, array $options = null)
{
    $id = $_POST['id'];
    $title = $_POST['title'];
    $picManager = $c->picture;
    if ($picManager->picInDb($id))
    {
        echo $picManager->changeTitle($id, $title);
    }
}
