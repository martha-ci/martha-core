<?php

namespace Martha\Core\Persistence\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Martha\Core\Domain\Entity\Build;
use Martha\Core\Domain\Repository\BuildRepositoryInterface;

/**
 * Class BuildRepository
 * @package Martha\Core\Persistence\Repository
 */
class BuildRepository extends AbstractRepository implements BuildRepositoryInterface
{
    /**
     * @var string
     */
    protected $entityType = '\Martha\Core\Domain\Entity\Build';

    /**
     * Restart a build.
     *
     * @param int $buildId
     */
    public function restartBuild($buildId)
    {
        $build = $this->getById($buildId);
        $build->setStatus(Build::STATUS_PENDING);
        $build->setSteps(new ArrayCollection());

        $this->flush();
    }

    /**
     * Go find the parent build using a list of candidates from the current build's history.
     *
     * @param array $builds
     * @return Build|bool
     */
    public function getParentBuild(array $builds)
    {
        $builder = $this->entityManager->createQueryBuilder()
            ->select('build')
            ->from($this->entityType, 'build')
            ->where('build.revisionNumber IN(:revisions)')
            ->setParameter('revisions', $builds);

        // There must be a better way to grab the last commit with a build before...
        $order = '';

        foreach ($builds as $index => $build) {
            $order .= 'WHEN build.revisionNumber = ' . $this->entityManager->getConnection()->quote($build) .
                ' THEN ' . intval($index) . ' ';
        }

        $order = '(CASE ' . $order . ' ELSE 200 END) AS HIDDEN ord ';

        $builder->addSelect($order);

        $builder->orderBy('ord', 'ASC')
            ->setMaxResults(1);

        $results = $builder->getQuery()->getResult();

        if (count($results)) {
            return $results[0];
        }

        return false;
    }
}
