<?php

namespace Martha\Core\Http;

/**
 * Class Request
 * @todo get rid of this stupid class
 * @deprecated
 * @package Martha\Core\Http
 */
class Request
{
    /**
     * @var string
     */
    protected $body;

    /**
     * @var array
     */
    protected $get = [];

    /**
     * @var array
     */
    protected $post = [];

    /**
     * @var array
     */
    protected $headers = [];

    /**
     * @param string $body
     * @return $this
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param array $get
     * @return $this
     */
    public function setGet($get)
    {
        $this->get = $get;
        return $this;
    }

    /**
     * @param array $headers
     * @return $this
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * @param string $var
     * @return string|array
     */
    public function getGet($var = '')
    {
        if ($var) {
            return isset($this->get[$var]) ? $this->get[$var] : null;
        }

        return $this->get;
    }

    /**
     * @param array $post
     * @return $this
     */
    public function setPost($post)
    {
        $this->post = $post;
        return $this;
    }

    /**
     * @param string $var
     * @return string|array
     */
    public function getPost($var = '')
    {
        if ($var) {
            return isset($this->post[$var]) ? $this->post[$var] : null;
        }

        return $this->post;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param string $name
     * @return bool|string
     */
    public function getHeader($name)
    {
        foreach ($this->headers as $key => $value) {
            if (strtolower($name) == strtolower($key)) {
                return $value;
            }
        }

        return false;
    }
}
