<?php

use Dumb\Dumb;
use Dumb\Response;

function escapeString(string $key): void
{
    if ('data' != $key) {
        $_POST[$key] = htmlspecialchars(stripslashes(trim($_POST[$key])));
    }
}

function numericType(string $key): void
{
    if (!is_numeric($_POST[$key]) || $_POST[$key] <= 0) {
        throw new \Exception('bad params:not numeric', Response::BAD_REQUEST);
    }
    $_POST[$key] = (int) $_POST[$key];
}

function passwordType(string $key): void
{
    if (!preg_match('#(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,256}#', $_POST[$key])) {
        throw new \Exception('bad params:not password', Response::BAD_REQUEST);
    }
}

function emailType(string $key): void
{
    if (!preg_match('#^[_A-Za-z0-9-\+]+(\.[_A-Za-z0-9-]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9]+)*(\.[A-Za-z]{2,63})$#', $_POST[$key])) {
        throw new \Exception('bad params:not email', Response::BAD_REQUEST);
    }
}

function pseudoType(string $key): void
{
    if (mb_strlen($_POST[$key]) > 30) {
        throw new \Exception('bad params:too long (>30 characters)', Response::BAD_REQUEST);
    }
}

function imageType(string $key)
{
    if (0 === strpos($_POST[$key], 'data:image/png;base64,')) {
        $_POST['type'] = 'png';
    } elseif (0 === strpos($_POST[$key], 'data:image/jpeg;base64,')) {
        $_POST['type'] = 'jpeg';
    } elseif (0 === strpos($_POST[$key], 'data:image/gif;base64,')) {
        $_POST['type'] = 'gif';
    } elseif (0 === strpos($_POST[$key], 'data:image/bmp;base64,')) {
        $_POST['type'] = 'bmp';
    } else {
        throw new \Exception('not base 64 jpeg/png/bmp/gif image', Response::BAD_REQUEST);
    }
    $_POST[$key] = base64_decode(str_replace(
        [' ', 'data:image/'.$_POST['type'].';base64,'],
        ['+', ''],
        $_POST[$key]
    ));
}

/**
 * trollBumper.
 * validation of forms for each routes.
 */
function trollBumper(Dumb $baka): void
{
    $formDefinition = [
        'comment' => [
            'post' => [
                'comment' => '',
            ],
            'patch' => [
                'comment' => '',
            ],
        ],
        'contact' => [
            'post' => [
                'name' => 'pseudo',
                'subject' => '',
                'email' => 'email',
                'message' => '',
            ],
        ],
        'login' => [
            'post' => [
                'password' => 'password',
                'pseudo' => 'pseudo',
            ],
        ],
        'picture' => [
            'patch' => [
                'title' => 'pseudo',
            ],
            'post' => [
                'picture' => 'image',
            ],
        ],
        'password' => [
            'patch' => [
                'password' => 'password',
            ],
            'post' => [
                'email' => 'email',
            ],
        ],
        'user' => [
            'patch' => [
                'pseudo' => 'pseudo',
                'email' => 'email',
            ],
            'post' => [
                'password' => 'password',
                'pseudo' => 'pseudo',
                'email' => 'email',
            ],
        ],
    ];
    $baka->setFormValidator(
        //factory
        function (string $key, $type) {
            if (empty($_POST[$key])) {
                throw new \Exception("key {$key} is missing", Response::BAD_REQUEST);
            }
            escapeString($key);
            switch ($type) {
            case 'numeric':
                numericType($key);

                break;
            case 'password':
                passwordType($key);

                break;
            case 'email':
                emailType($key);

                break;
            case 'pseudo':
                pseudoType($key);

                break;
            case 'image':
                imageType($key);

                break;
            }
        },
        $formDefinition
    );
}
