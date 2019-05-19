<?php

use \Dumb\Dumb;

/**
 * troolBumper.
 * validation of forms for each routes
 *
 * @param Dumb $baka
 */
function trollBumper(Dumb $baka)
{
    $baka->eatF(
        function ($key, $type): int {
                    var_dump($_REQUEST);exit;
            if (!isset($_POST[$key]) || !$_POST[$key])
            {
                return 401;
            }
            if ('data' != $key)
            {
                $_POST[$key] = htmlspecialchars(stripslashes(trim($_POST[$key])));
            }
            switch ($type) {
            case 'numeric':
                if (!is_numeric($_POST[$key]) || $_POST[$key] <= 0)
                {
                    return 401;
                }
                $_POST[$key] = (int) $_POST[$key];

                break;
            case 'password':
                if (!preg_match('#(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,256}#', $_POST[$key]))
                {
                    return 401;
                }

                break;
            case 'email':
                if (!preg_match('#^[_A-Za-z0-9-\+]+(\.[_A-Za-z0-9-]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9]+)*(\.[A-Za-z]{2,63})$#', $_POST[$key]))
                {
                    return 401;
                }

                break;
            case 'pseudo':
                if (mb_strlen($_POST[$key]) > 30)
                {
                    return 401;
                }

                break;
            case 'data':
                if (0 === strpos($_POST['data'], 'data:image/png;base64,'))
                {
                    $_POST['type'] = 'png';
                }
                elseif (0 === strpos($_POST['data'], 'data:image/jpeg;base64,'))
                {
                    $_POST['type'] = 'jpeg';
                }
                else
                {
                    return 401;
                }
                $_POST['data'] = str_replace(
                    [' ', 'data:image/png;base64,'],
                    ['+', ''],
                    $_POST['data']
                );

                break;
            }

            return 0;
        },
        [
            '/login' => ['password' => 'password', 'pseudo' => 'pseudo'],
            '/password' => ['password' => 'password'],
            '/signup' => ['password' => 'password', 'pseudo' => 'pseudo', 'email' => 'email'],
            '/contact' => ['name' => 'pseudo', 'subject' => '', 'email' => 'email', 'message' => ''],
            '/settings' => ['pseudo' => 'pseudo', 'email' => 'email'],
            '/addLike' => ['id' => 'numeric'],
            '/listPicsByLike' => ['start' => 'numeric'],
            '/listPicsByDate' => ['start' => 'numeric'],
            '/addComment' => ['id' => 'numeric', 'comment' => ''],
            '/changeTitle' => ['id' => 'numeric', 'title' => 'pseudo'],
            '/deletePic' => ['url' => ''],
            '/createPic' => ['data' => 'data'],
            '/reinitPost' => ['pseudo' => 'pseudo'],
        ]
    );
}
