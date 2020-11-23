<?php

declare(strict_types=1);

namespace Dumb;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Class Response.
 */
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

    /** @var int */
    private $code;

    /** @var string */
    private $reasonPhrase;

    /** @var StreamInterface */
    private $body;

    /** @var array */
    private $headers;

    //temp: to remove asap
    /** @var string */
    private $message = '';

    /** @var Response */
    private static $instance;

    public static function getInstance(int $code = 200, string $reasonPhrase = '', array $headers = [], ?StreamInterface $body = null): Response
    {
        if (false == self::$instance) {
            self::$instance = new Response($code, $reasonPhrase, $headers, $body);
        }

        return self::$instance;
    }

    public function getProtocolVersion()
    {
        return explode('/', $_SERVER['SERVER_PROTOCOL'])[1];
    }

    public function withProtocolVersion($version)
    {
        if ('1.1' === $version || '1.0' === $version) {
            $_SERVER['SERVER_PROTOCOL'] = "http/{$version}";
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
            return implode(',', $this->headers[$name]);
        }

        return '';
    }

    public function withHeader($name, $value)
    {
        $name = strtolower($name);
        $this->headers = [$name => [$value]];

        return $this;
    }

    public function withAddedHeader($name, $value)
    {
        $name = strtolower($name);

        $headers = $this->headers;
        if (!isset($headers[$name])) {
            $headers[$name] = [];
        }
        $headers[$name][] = $value;
        $this->headers = $headers;

        return $this;
    }

    public function withoutHeader($name)
    {
        $this->headers = [];

        return $this;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function withBody(StreamInterface $body)
    {
        $this->body = $body;

        return $this;
    }

    public function getStatusCode()
    {
        return $this->code;
    }

    public function withStatus($code, $reasonPhrase = '')
    {
        if ($code < 100 || $code > 599) {
            throw new \InvalidArgumentException("{$code}: this code does not exist.");
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

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    private function __construct(int $code = 200, string $reasonPhrase = '', array $headers = [], ?StreamInterface $body = null): void
    {
        if (!$reasonPhrase && isset(self::HTTP_CODE[$code])) {
            $this->reasonPhrase = self::HTTP_CODE[$code];
        } else {
            $this->reasonPhrase = $reasonPhrase;
        }
        $this->code = $code;
        $this->headers = $headers;
        $this->body = $body;
    }
}
