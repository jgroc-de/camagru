<?php

declare(strict_types=1);

namespace Dumb;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class Response implements ResponseInterface
{
    const HTTP_CODE = [
        42 => 'OK',
        200 => 'OK',
        201 => 'CREATED',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        500 => 'Server Internal Error',
    ];

    const OK = 200;
    const CREATED = 201;
    const BAD_REQUEST = 400;
    const UNAUTHORIZED = 401;
    const FORBIDDEN = 403;
    const NOT_FOUND = 404;
    const METHOD_NOT_ALLOWED = 405;
    const INTERNAL_SERVER_ERROR = 500;

    /** @var int $code */
    private $code;

    /** @var string $reasonPhrase */
    private $reasonPhrase;

    /** @var StreamInterface $body */
    private $body;

    /** @var array $headers */
    private $headers;

    //temp: to remove asap
    /** @var string $message */
    private $message;

    public function __construct(int $code = 200, string $reasonPhrase = "", array $headers = [], ?StreamInterface $body = null)
    {
        $this->reasonPhrase = $reasonPhrase;
        $this->code = $code;
        $this->headers = $headers;
        $this->body = $body;
    }

    public function getProtocolVersion()
    {
        return explode('/', $_SERVER['SERVER_PROTOCOL'])[1];
    }

    public function withProtocolVersion($version)
    {
        if ($version === '1.1' || $version === '1.0') {
            $_SERVER['SERVER_PROTOCOL'] = "http/$version";
        }

        return $this;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function hasHeader($name)
    {
        return empty($this->headers);
    }

    public function getHeader($name)
    {
        $name = strtolower($name);
        if (isset($this->headers[$name])) {
            return $this->headers[$name];
        }

        return [];
    }

    public function getHeaderLine($name)
    {
        $name = strtolower($name);
        if (isset($this->headers[$name])) {
            return implode(",", $this->headers[$name]);
        }

        return "";
    }

    public function withHeader($name, $value)
    {
        $name = strtolower($name);

        $headers = [$name => [$value]];

        return new Response($this->code, $this->reasonPhrase, $headers, $this->body);
    }

    public function withAddedHeader($name, $value)
    {
        $name = strtolower($name);

        $headers = $this->headers;
        if (!isset($headers[$name])) {
            $headers[$name] = [];
        }
        $headers[$name][] = $value;

        return new Response($this->code, $this->reasonPhrase, $headers, $this->body);
    }

    public function withoutHeader($name)
    {
        return new Response($this->code, $this->reasonPhrase, [], $this->body);
    }

    public function getBody()
    {
        return $this->body;
    }

    public function withBody(StreamInterface $body)
    {
        return new Response($this->code, $this->reasonPhrase, $this->headers, $body);
    }

    public function getStatusCode()
    {
        return $this->code;
    }

    public function withStatus($code, $reasonPhrase = '')
    {
        if ($code < 100 || $code > 599) {
            throw new \InvalidArgumentException("$code: this code does not exist.");
        }
        $this->code = $code;
        if (!$reasonPhrase && isset(self::HTTP_CODE[$code])) {
            $this->reasonPhrase = self::HTTP_CODE[$code];
        }

        return $this;
    }

    public function getReasonPhrase()
    {
        return $this->reasonPhrase;
    }

    public function setMessage(string $message)
    {
        $this->message = $message;
    }

    public function send()
    {
        header('Cache-Control: max-age=3600');
        header($_SERVER['SERVER_PROTOCOL'] . ' ' . $this->code . ' ' . Response::HTTP_CODE[$this->code]);
        echo $this->message;
    }
}
