<?php

namespace Martha\Core\Job;

use Martha\Core\Domain\Entity\Build;
use Martha\Core\Domain\Repository\BuildRepositoryInterface;

/**
 * Class Queue
 * @package Martha\Core\Job
 */
class Queue
{
    /**
     * @var \Martha\Core\Domain\Repository\BuildRepositoryInterface
     */
    protected $buildRepository;

    /**
     * @var int
     */
    protected $maxBuildsInProgress = 5;

    /**
     * Setup the Queue object.
     *
     * @param BuildRepositoryInterface $build
     * @param array $config
     */
    public function __construct(BuildRepositoryInterface $build, array $config)
    {
        $this->buildRepository = $build;

        if (isset($config['max_processes'])) {
            $this->maxBuildsInProgress = max((int)$config['max_processes'], 1);
        }
    }

    /**
     * Determine if there are any builds pending, and launch any of those builds up to the max number of builds
     * allowed to run at once.
     */
    public function run()
    {
        $building = $this->buildRepository->getBy(['status' => 'building']);

        if (count($building) < $this->maxBuildsInProgress) {
            $pending = $this->buildRepository->getBy(
                ['status' => 'pending'],
                ['created' => 'ASC'],
                $this->maxBuildsInProgress - count($building)
            );

            foreach ($pending as $build) {
                // Find a cleaner, more graceful way to do this:
                exec('./bin/martha ' . $build->getId() . ' > /dev/null &');
            }
        }
    }
}
