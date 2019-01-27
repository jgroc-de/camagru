<?php

require '../dumb/Dumbee.php';
require '../dumb/Bunkee.php';

class Dumb extends Bunkee
{
    public $container;

    /**
     * __construct.
     */
    public function __construct()
    {
        spl_autoload_register(function ($class) {
            require '../app/model/'.$class.'.php';
        });
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
    public function dumb($args = null)
    {
		$this->middleware(); 
		$this->form();
		if ($this->error === 0)
        {
            require '../app/controller/'.strtolower($_SERVER['REQUEST_METHOD']).$this->uri.'.php';
            $response = (ltrim($this->uri, '/'))($this->container, $args);
            if ($response)
            {
                header('HTTP/1.1 '.$response['code'].' '.self::HTTP_CODE[$response['code']]);
                unset($response['code']);
                echo json_encode($response);
            }
        }
        else
        {
            require '../app/controller/error.php';
			$error['code'] = $this->error;
			$error['message'] = self::HTTP_CODE[$this->error];
            error($this->container, $error);
        }
    }
}
