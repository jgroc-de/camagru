<?php

declare(strict_types=1);

namespace App\Controller;

use Dumb\Patronus;

class like extends Patronus
{
	protected $pictureManager;

    public function post()
    {
        $this->response['likes_counter'] = $this->pictureManager->addlike($_POST['id']);
        if ($this->response['likes_counter'] < 0) {
            $this->response['flash'] = 'Already liked!';
        }
    }

	/**
    public function delete()
    {
    }

    public function patch()
    {
    }
 	*/

	protected function setup()
	{
        $this->pictureManager = $this->container['picture']($this->container);
	}
}
