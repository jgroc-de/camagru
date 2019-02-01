<?php

$baka->eat(
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

$baka->eat(
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

$baka->eat(
    function () {
        if (!isset($_GET['id']) || !is_numeric($_GET['id']))
        {
            return 401;
        }
        $_GET['id'] = (int) $_GET['id'];

        return 0;
    },
    [
        '/picture',
    ]
);

$baka->eat(
    function () {
        if (!isset($_GET['log'], $_GET['key']))
        {
            return 401;
        }

        return 0;
    },
    [
        '/reinitGet',
    ]
);
