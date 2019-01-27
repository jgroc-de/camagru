<?php

/**
 * validation.
 *
 * @param Dumbee $container
 * @param array  $options
 */
function validation(Dumbee $c, array $options)
{
    if (isset($_GET['log'], $_GET['key']))
    {
        $c->user->checkValidationMail($_GET['log'], $_GET['key']);
    }
}
