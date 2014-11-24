<?php

namespace Martha\Core\Plugin\View;

/**
 * Class DashboardWidget
 * @package Martha\Core\Plugin\View
 */
class DashboardWidget extends AbstractView
{
    /**
     * @param string $title
     * @param string $size
     */
    public function __construct($title, $size)
    {
        $this->setVariable('widgetTitle', $title);
        $this->setVariable('widgetSize', $size);
    }
}
