<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\MailManager;
use Dumb\Dumb;
use Dumb\Patronus;

class contact extends Patronus
{
    /** @var MailManager */
    private $mailManager;

    public function __construct(string $method, int $code = 200)
    {
        parent::__construct($method, $code);
        $this->mailManager = Dumb::$container['mail']();
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
