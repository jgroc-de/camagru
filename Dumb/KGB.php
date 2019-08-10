<?php

declare(strict_types=1);

namespace Dumb;

/**
 * this is a form validator.
 */
class KGB
{
    private $formParams = [];

    public function add($function, array $formParams)
    {
        if (!empty($formParams)) {
            $this->formParams[] = [
                'function' => $function,
                'params' => $formParams,
            ];
        }
    }

    public function check()
    {
        foreach ($this->formParams as $param) {
            foreach ($param['params'] as $key => $type) {
                $param['function']($key, $type);
            }
        }
    }
}
