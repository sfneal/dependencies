<?php

namespace Sfneal\Dependencies\Utils;

class Url
{
    /**
     * @var string
     */
    protected $uri;

    /**
     * @var array
     */
    protected $params;

    /**
     * Static URL constructor.
     *
     * @param  string  $uri
     * @return self
     */
    public static function from(string $uri): self
    {
        return new self($uri);
    }

    /**
     * Add query parameters to a URL.
     *
     * @param  array|null  $params
     * @return $this
     */
    public function withParams(array $params = null): self
    {
        $this->params = $params;

        return $this;
    }

    /**
     * Url constructor.
     *
     * @param  string  $uri
     * @param  array|null  $params
     */
    public function __construct(string $uri, array $params = null)
    {
        $this->uri = $uri;
        $this->withParams($params);
    }

    /**
     * Retrieve a URL with params appended to the query string.
     *
     * @return string
     */
    public function get(): string
    {
        return self::generateUrl($this->uri).self::generateQueryString($this->params);
    }

    /**
     * Generate a URL.
     *
     * @param  string  $uri
     * @return string
     */
    protected static function generateUrl(string $uri): string
    {
        return 'https://'.$uri;
    }

    /**
     * Generate a query string.
     *
     * @param  array|null  $params
     * @return string
     */
    protected static function generateQueryString(array $params = null): string
    {
        if (! is_null($params)) {
            $query = '?';

            $paramStrings = [];
            foreach (array_unique($params) as $key => $value) {
                if ($key != 0) {
                    $paramStrings[] = "{$key}={$value}";
                }
                else {
                    $paramStrings[] = "{$value}";
                }
            }

            return $query.implode('&', $paramStrings);
        }

        return '';
    }
}
