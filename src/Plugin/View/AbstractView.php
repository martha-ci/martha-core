<?php

namespace Martha\Core\Plugin\View;

/**
 * Class AbstractView
 * @package Martha\Core\Plugin\View
 */
class AbstractView
{
    /**
     * @var array
     */
    protected $variables = [];

    /**
     * @var string
     */
    protected $viewFile;

    /**
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function getVariable($name, $default = null)
    {
        if (array_key_exists($name, $this->variables)) {
            return $this->variables[$name];
        }

        return $default;
    }

    /**
     * Set view variable
     *
     * @param string $name
     * @param mixed $value
     * @return $this
     */
    public function setVariable($name, $value)
    {
        $this->variables[$name] = $value;
    }

    /**
     * Set view variables en masse
     *
     * @throws \InvalidArgumentException
     * @param array|\ArrayAccess $variables
     * @param boolean $overwrite
     * @return $this
     */
    public function setVariables($variables, $overwrite = false)
    {
        if (!is_array($variables)) {
            throw new \InvalidArgumentException(sprintf(
                '%s: expects an array; received "%s"',
                __METHOD__,
                (is_object($variables) ? get_class($variables) : gettype($variables))
            ));
        }

        if ($overwrite) {
            $this->variables = $variables;
            return $this;
        }

        foreach ($variables as $key => $value) {
            $this->setVariable($key, $value);
        }

        return $this;
    }

    /**
     * Get view variables
     *
     * @return array|\ArrayAccess
     */
    public function getVariables()
    {
        return $this->variables;
    }

    /**
     * @param string $viewFile
     * @return $this
     */
    public function setViewFile($viewFile)
    {
        $this->viewFile = $viewFile;
        return $this;
    }

    /**
     * @return string
     */
    public function getViewFile()
    {
        return $this->viewFile;
    }
}
