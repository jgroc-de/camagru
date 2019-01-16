<?php

function changeTitle($c)
{
    if (isset($_GET['q'], $_GET['title']))
    {
        $id = $_GET['q'];
        $title = $_GET['title'];
        $picManager = $c->picture;
        if ($picManager->picInDb($id) && strlen($title) < 40)
            echo $picManager->changeTitle($id, $title);
    }
}
