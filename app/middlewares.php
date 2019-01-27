<?php

$api->add(
    function () {
        if (isset($_SESSION['pseudo']))
        {
            return 401;
        }

        return 0;
    },
    [
        '/login',
        '/signup',
        '/reinitPost',
        '/reinitGet',
    ]
);

$api->add(
    function () {
        if (!isset($_SESSION['pseudo']))
        {
            return 403;
        }

        return 0;
    },
    [
        '/logout',
        '/camagru',
        '/addComment',
        '/addLike',
        '/changeTitle',
        '/createPic',
        '/deletePic',
        '/getSettings',
        '/settings',
        '/password',
    ]
);

$api->add(
    function () {
        if (!isset($_GET['id']) || !is_numeric($_GET['id']))
        {
            return 401;
        }

        return 0;
    },
    [
        '/picture',
    ]
);
