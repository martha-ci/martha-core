<?php

namespace Martha\Core\Plugin\ArtifactHandlers;

use Martha\Core\Plugin\View\TabbedPane;

/**
 * Class DashboardWidgetProviderInterface
 * @package Martha\Core\Plugin\ArtifactHandlers
 */
interface DashboardWidgetProviderInterface
{
    /**
     * @return array|TabbedPane
     */
    public function getDashboardWidget();
}
