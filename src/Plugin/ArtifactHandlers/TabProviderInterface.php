<?php

namespace Martha\Core\Plugin\ArtifactHandlers;

use Martha\Core\Plugin\View\TabbedPane;

/**
 * Class TabProviderInterface
 * @package Martha\Core\Plugin\ArtifactHandlers
 */
interface TabProviderInterface
{
    /**
     * @return array|TabbedPane
     */
    public function getTabbedPane();
}
