<?php

namespace Martha\Core\Domain\Entity\Build;

use Martha\Core\Domain\Entity\AbstractEntity;

/**
 * Class Alert
 * @package Martha\Core\Domain\Entity\Build
 */
class Alert extends AbstractEntity
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
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $description;

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
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function setDescription($message)
    {
        $this->description = $message;
        return $this;
    }
}
