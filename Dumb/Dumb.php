<?php

declare(strict_types=1);

namespace Dumb;

class Dumb extends Bunkee
{
    public $container;

    /**
     * __construct.
     */
    public function __construct()
    {
        /*spl_autoload_register(function ($class) {
            require '../app/Model/'.$class.'.php';
        });*/
        $request = explode('/', $_SERVER['REQUEST_URI']);
        $this->uri = '/'.$request[1];
        if (isset($request[2]))
        {
            $_GET['id'] = $request[2];
        }
    }

    /**
     * setContainer.
     *
     * @param array $functions
     */
    public function setContainer(array $functions)
    {
        $this->container = new Dumbee($functions);
    }

    /**
     * dumb.
     *
     * @param mixed $args
     */
    public function kamehameha($args = null)
    {
        $this->middleware();
        $this->form();
        if (0 === $this->error)
        {
            $class = '\App\Controller\\'.strtolower($_SERVER['REQUEST_METHOD']).'\\'.(ltrim($this->uri, '/'));
            $letter = new $class();
        }
        else
        {
            $letter = new \App\Controller\error($this->error);
        }
        $letter->trap($this->container);
        header('HTTP/1.1 '.$letter->code.' '.self::HTTP_CODE[$letter->code]);
        if ($letter->code >= 400 && 'GET' === $_SERVER['REQUEST_METHOD'])
        {
            $letter = new \App\Controller\error($letter->code);
        }
        $letter->bomb($args);
    }
}
