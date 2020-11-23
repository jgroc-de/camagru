<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\MailManager;
use Dumb\Patronus;

class contact extends Patronus
{
    /** @var MailManager */
    private $mailManager;

    public function __construct(array $container, string $method, int $code = 200)
    {
        $this->method = $method;
        $this->code = $code;
        $this->mailManager = $container['mail']();
    }

    public function post(): void
    {
        $this->response['flash'] = 'Thx!';
    }

    public function bomb(): string
    {
        $this->mailManager->sendContactMail();

        return json_encode($this->response);
    }
}
