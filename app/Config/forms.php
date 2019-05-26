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
            '/comment' => [
                'post' => [
                    'id' => 'numeric',
                    'comment' => ''
                ],
                'patch' => [
                    'id' => 'numeric',
                    'comment' => ''
                ]
            ],
            '/contact' => [
                'post' => [
                    'name' => 'pseudo',
                    'subject' => '',
                    'email' => 'email',
                    'message' => ''
                ]
            ],
            '/login' => [
                'post' => [
                    'password' => 'password',
                    'pseudo' => 'pseudo'
                ]
            ],
            '/like' => [
                'post' => [
                    'id' => 'numeric'
                ]
            ],
            '/pics' => [
                'get' => [
                    'start' => 'numeric',
                    'by' => ''
                ]
            ],
            '/picture' => [
                'delete' => [
                    'url' => ''
                ],
                'patch' => [
                    'id' => 'numeric',
                    'title' => 'pseudo'
                ],
                'post' => [
                    'data' => 'data'
                ],
            ],
            '/password' => [
                'patch' => [
                    'password' => 'password'
                ],
                'post' => [
                    'pseudo' => 'pseudo'
                ],
            ],
            '/user' => [
                'patch' => [
                    'pseudo' => 'pseudo',
                    'email' => 'email'
                ],
                'post' => [
                    'password' => 'password',
                    'pseudo' => 'pseudo',
                    'email' => 'email'
                ],
            ],
        ]
    );
}
