<?php

declare(strict_types=1);

namespace Dumb;

class Patronus
{
    public $code;

    protected $response = [];

    public function __construct(int $code = 200)
    {
        $this->code = $code;
    }

    public function trap(Dumbee $c)
    {
    }

    public function bomb(array $options)
    {
        if ($this->code >= 400 && !isset($this->response['flash']))
        {
            $this->response['flash'] = 'Not Found…';
        }
        echo json_encode($this->response);
    }

	protected function render(string $path = '../app/view/template.html', array $response)
	{
		require $path;
	}
}
