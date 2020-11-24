<?php

namespace Dumb;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

class Request implements ServerRequestInterface
{
    /** @var null|array */
    private $queryParams;

    public function getProtocolVersion()
    {
        // TODO: Implement getProtocolVersion() method.
        return '';
    }

    public function withProtocolVersion($version)
    {
        // TODO: Implement withProtocolVersion() method.
        return $this;
    }

    public function getHeaders()
    {
        // TODO: Implement getHeaders() method.
        return [['']];
    }

    public function hasHeader($name)
    {
        // TODO: Implement hasHeader() method.
        return false;
    }

    public function getHeader($name)
    {
        // TODO: Implement getHeader() method.
        return [''];
    }

    public function getHeaderLine($name)
    {
        // TODO: Implement getHeaderLine() method.
        return '';
    }

    public function withHeader($name, $value)
    {
        // TODO: Implement withHeader() method.
        return $this;
    }

    public function withAddedHeader($name, $value)
    {
        // TODO: Implement withAddedHeader() method.
        return $this;
    }

    public function withoutHeader($name)
    {
        // TODO: Implement withoutHeader() method.
        return $this;
    }

    public function getBody()
    {
        // TODO: Implement getBody() method.
    }

    public function withBody(StreamInterface $body)
    {
        // TODO: Implement withBody() method.
        return $this;
    }

    public function getRequestTarget()
    {
        // TODO: Implement getRequestTarget() method.
        return '';
    }

    public function withRequestTarget($requestTarget)
    {
        // TODO: Implement withRequestTarget() method.
        return $this;
    }

    public function getMethod()
    {
        // TODO: Implement getMethod() method.
        return '';
    }

    public function withMethod($method)
    {
        // TODO: Implement withMethod() method.
        return $this;
    }

    public function getUri()
    {
        // TODO: Implement getUri() method.
    }

    public function withUri(UriInterface $uri, $preserveHost = false)
    {
        // TODO: Implement withUri() method.
        return $this;
    }

    public function getServerParams()
    {
        // TODO: Implement getServerParams() method.
        return [];
    }

    public function getCookieParams()
    {
        // TODO: Implement getCookieParams() method.
        return [];
    }

    public function withCookieParams(array $cookies)
    {
        // TODO: Implement withCookieParams() method.
        return $this;
    }

    public function getQueryParams()
    {
        if (null === $this->queryParams) {
            $this->setQueryParams();
        }

        return $this->queryParams;
    }

    public function withQueryParams(array $query)
    {
        // TODO: Implement withQueryParams() method.
        return $this;
    }

    public function getUploadedFiles()
    {
        // TODO: Implement getUploadedFiles() method.
        return [];
    }

    public function withUploadedFiles(array $uploadedFiles)
    {
        // TODO: Implement withUploadedFiles() method.
        return $this;
    }

    public function getParsedBody()
    {
        // TODO: Implement getParsedBody() method.
        return null;
    }

    public function withParsedBody($data)
    {
        // TODO: Implement withParsedBody() method.
        return $this;
    }

    public function getAttributes()
    {
        // TODO: Implement getAttributes() method.
        return [];
    }

    public function getAttribute($name, $default = null)
    {
        // TODO: Implement getAttribute() method.
    }

    public function withAttribute($name, $value)
    {
        // TODO: Implement withAttribute() method.
        return $this;
    }

    public function withoutAttribute($name)
    {
        // TODO: Implement withoutAttribute() method.
        return $this;
    }

    private function setQueryParams(): void
    {
        $queryParams = [];
        if (!isset($_SERVER['QUERY_STRING'])) {
            $this->queryParams = $queryParams;
        } else {
            $params = explode('&', $_SERVER['QUERY_STRING']);
            foreach ($params as $param) {
                $values = explode('=', $param);
                if (!in_array(count($values), [1, 2])) {
                    continue;
                }
                if (1 === count($values)) {
                    $values[] = true;
                }
                $queryParams[$values[0]] = $values[1];
            }

            $this->queryParams = $queryParams;
        }
    }
}
