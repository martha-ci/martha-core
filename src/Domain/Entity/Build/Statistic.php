<?php

namespace Martha\Core\Domain\Entity\Build;

use Martha\Core\Domain\Entity\AbstractEntity;

/**
 * Class Statistic
 * @package Martha\Core\Domain\Entity\Build
 */
class Statistic extends AbstractEntity
{
    /**
     * @var \Martha\Core\Domain\Entity\Build
     */
    protected $build;

    /**
     * @var \Martha\Core\Domain\Entity\Plugin
     */
    protected $plugin;

    /**
     * @var String
     */
    protected $name;

    /**
     * @var string
     */
    protected $value;

    /**
     * @return \Martha\Core\Domain\Entity\Build
     */
    public function getBuild()
    {
        return $this->build;
    }

    /**
     * @param \Martha\Core\Domain\Entity\Build $build
     * @return $this
     */
    public function setBuild($build)
    {
        $this->build = $build;
        return $this;
    }

    /**
     * @return \Martha\Core\Domain\Entity\Plugin
     */
    public function getPlugin()
    {
        return $this->plugin;
    }

    /**
     * @param \Martha\Core\Domain\Entity\Plugin $plugin
     * @return $this
     */
    public function setPlugin($plugin)
    {
        $this->plugin = $plugin;
        return $this;
    }

    /**
     * @return String
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param String $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }
}
