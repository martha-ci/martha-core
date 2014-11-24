<?php

namespace Martha\Core;

/**
 * Class Hash
 * @package Martha\Core
 */
class Hash
{
    /**
     * @var array
     */
    protected $data;

    /**
     * Create the hash object, optionally by passing it an array of data to store.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * Determine if the hash has a value for the given key.
     *
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        return array_key_exists($key, $this->data);
    }

    /**
     * Get the value stored at the given key.
     *
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        if ($this->has($key)) {
            return $this->data[$key];
        }

        return null;
    }

    /**
     * Set a value stored at a given key.
     *
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function set($key, $value)
    {
        $this->data[$key] = $value;
        return $this;
    }

    /**
     * Remove a value stored at a given key.
     *
     * @param string $key
     * @return $this
     */
    public function remove($key)
    {
        if ($this->has($key)) {
            unset($this->data[$key]);
        }
        return $this;
    }

    /**
     * Export the data as a JSON string.
     *
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->data);
    }

    /**
     * Export the raw array data stored in this hash object.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }
}
