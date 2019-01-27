<?php

/**
 * addLike.
 *
 * @param Dumbee $c
 * @param array  $options
 *
 * @return array
 */
function addLike(Dumbee $c, array $options = null)
{
    $picManager = $c->picture;

    if (($picManager->picInDb($_POST['id'])))
    {
        $response['likes_counter'] = $picManager->addlike($_POST['id']);
        if ($response['likes_counter'] < 0)
        {
            $response['code'] = 401;
            $response['flash'] = 'Already liked!';
        }
        else
        {
            $response['code'] = 200;
        }
    }
    else
    {
        $response['code'] = 404;
        $response['flash'] = "Picture doesn't exist anymore";
    }

    return $response;
}
