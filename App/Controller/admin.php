<?php


namespace App\Controller;


use Dumb\Patronus;

class admin extends Patronus
{
    public function get(): void
    {
        echo phpinfo();
    }
}