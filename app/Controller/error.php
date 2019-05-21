<?php

declare(strict_types=1);

namespace App\Controller;

use Dumb\Patronus;

class error extends Patronus
{
    const HTTP_CODE = [
        200 => 'OK',
        401 => 'Bad Request',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        500 => 'Server Internal Error',
    ];

    public function trap(array $c)
    {
    }

    public function bomb(array $options)
    {
        $this->{$this->method}($options);
    }

    private function get(array $options)
    {
        $options['code'] = $this->code;
        $options['message'] = self::HTTP_CODE[$this->code];
        $options['components'] = [
            '/common/about.php',
            '/common/contact.php',
        ];
        $options['header'] = [
            '/common/error.html',
        ];

        require __DIR__.'/../View/template.html';
    }

    public function __call(string $method, array $options)
    {
        $this->json();
    }
}
