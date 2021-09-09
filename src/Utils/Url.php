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
     * Url constructor.
     *
     * @param  string  $uri
     * @param  array|null  $params
     */
    public function __construct(string $uri, array $params = null)
    {
        $this->uri = $uri;
        $this->params = $params;
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
    public static function generateUrl(string $uri): string
    {
        return 'https://'.$uri;
    }

    /**
     * Generate a query string.
     *
     * @param  array|null  $params
     * @return string
     */
    public static function generateQueryString(array $params = null): string
    {
        if (! is_null($params)) {
            $query = '?';

            $paramStrings = [];
            foreach (array_unique($params) as $key => $value) {
                $paramStrings[] = "{$key}={$value}";
            }

            return $query.implode('&', $paramStrings);
        }

        return '';
    }
}
