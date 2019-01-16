<?php

function deletePic($c)
{
    if (isset($_GET['url']))
    {
        $picManager = $c->picture;
        $pic = $picManager->getPicByUrl($_GET['url']);
        if ($pic && $_SESSION['id'] === $pic['id_author'])
        {
            $picManager->deletePic($pic['id'], $pic['id_author']);
            unlink($_GET['url']); 
        }
    }
} 
