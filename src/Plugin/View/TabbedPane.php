<?php

namespace Martha\Core\Plugin\View;

/**
 * Class TabbedPane
 * @package Martha\Core\Plugin\View
 */
class TabbedPane extends AbstractView
{
    /**
     * @param string $tabTitle
     */
    public function __construct($tabTitle)
    {
        $this->setVariable('tabTitle', $tabTitle);
    }
}
