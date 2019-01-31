<?php

namespace Dumb;

//require 'Bunkee.php';
//require 'Dumbee.php';
use function App\Controller\error;

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
			$response = new $class($this->container, $args);
            if ($_SERVER['REQUEST_METHOD'] === 'POST')
            {
                header('HTTP/1.1 '.$response->code.' '.self::HTTP_CODE[$response->code]);
                echo json_encode($response->args);
            }
        }
        else
        {
            $error['code'] = $this->error;
            $error['message'] = self::HTTP_CODE[$this->error];
            new \App\Controller\error($this->container, $error);
        }
    }
}
