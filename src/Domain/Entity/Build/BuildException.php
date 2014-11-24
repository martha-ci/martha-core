<?php

namespace Martha\Core\Domain\Entity\Build;

use Martha\Core\Domain\Entity\AbstractEntity;
use Martha\Core\Domain\Entity\Build;
use Martha\Core\Domain\Entity\Plugin;

/**
 * Class BuildException
 * @package Martha\Core\Domain\Entity\Build
 */
class BuildException extends AbstractEntity
{
    /**
     * @var Build
     */
    protected $build;

    /**
     * @var Plugin
     */
    protected $plugin;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var string
     */
    protected $asset;

    /**
     * @var string
     */
    protected $reference;

    /**
     * @var string
     */
    protected $url;

    /**
     * @return Build
     */
    public function getBuild()
    {
        return $this->build;
    }

    /**
     * @param Build $build
     * @return $this
     */
    public function setBuild($build)
    {
        $this->build = $build;
        return $this;
    }

    /**
     * @return Plugin
     */
    public function getPlugin()
    {
        return $this->plugin;
    }

    /**
     * @param Plugin $plugin
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
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return string
     */
    public function getAsset()
    {
        return $this->asset;
    }

    /**
     * @param string $asset
     * @return $this
     */
    public function setAsset($asset)
    {
        $this->asset = $asset;
        return $this;
    }

    /**
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     * @return $this
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }
}
