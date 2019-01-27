<?php

function listpicsByLike($c, $options)
{
    $options['trend'] = true;
    $picManager = $c->picture;
    $count = $picManager->countPics();
    $start = isset($_GET['start']) ? $_GET['start'] : 0;

    $count = $count[0] / 6;
    if (!is_numeric($start) || $start > $count) {
        $start = 0;
    }
    $pics = $picManager->getPicsByLike($start * 6);
    $view = 'Trending Pictures';
    $main = '/listPicView.html';
    require __DIR__.'/../../view/template.php';
}
