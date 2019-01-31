<?php

/**
 * contact.
 *
 * @param Dumbee $c
 * @param array  $options
 *
 * @return array
 */
function contact(Dumbee $c, array $options = null)
{
    $c->mail->sendContactMail();
	$response = [
		'code' => '200',
		'flash' => 'Thx!',
	];

    return $response;
}
