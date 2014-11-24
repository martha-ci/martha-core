<?php

namespace Martha\Core\Scm\Provider;

use Martha\Core\Domain\Entity\Build;

/**
 * Class ProviderFactory
 * @package Martha\Scm\Provider
 */
class ProviderFactory
{
    /**
     * @param Build $build
     * @return bool|AbstractProvider
     */
    public static function createForBuild(Build $build)
    {
        switch (strtolower($build->getProject()->getScm())) {
            case 'git':
                $git = new Git();

                if ($build->getForkUri()) {
                    $git->setRepository($build->getForkUri());
                } else {
                    $git->setRepository($build->getProject()->getUri());
                }
                return $git;
        }

        return false;
    }
}
