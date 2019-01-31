<?php

namespace App\Controller\get;

use Dumb\Dumbee;

/**
 * reinitGet.
 *
 * @param Dumbee $c
 * @param array  $options
 *
 * @return array
 */
class reinitGet
{
	public function __construct(Dumbee $c, array $options)
	{
		$userManager = $c->user;

		$response['code'] = 200;
		if (isset($_GET['log'], $_GET['key']))
		{
			$pseudo = $_GET['log'];
			if ($userManager->pseudoInDb($pseudo) && $userManager->checkValidationMail($pseudo, $_GET['key']))
			{
				logUser($userManager->getUser($pseudo));
			}
			else
			{
				$response['code'] = 400;
				$response['flash'] = "Bimp! N'y aurait-il pas une petite erreur de typo dans votre pseudo?";
			}
		}
		if (isset($_SESSION['flash']))
		{
			$response['flash'] = $_SESSION['flash'];
		}

		return $response;
	}
}
