<?php

namespace Martha\Plugin\PhpUnit;

use Martha\Core\Domain\Entity\Build;
use Martha\Core\Plugin\AbstractArtifactHandler;
use Martha\Core\Plugin\ArtifactHandlers\BuildStatisticInterface;
use Martha\Core\Plugin\ArtifactHandlers\TextBasedResultInterface;

/**
 * Class CloverArtifactHandler
 * @package Martha\Plugin\PhpCodeSniffer
 */
class CloverArtifactHandler extends AbstractArtifactHandler implements
    TextBasedResultInterface,
    BuildStatisticInterface
{
    /**
     * @var string
     */
    protected $name = 'phpunit-clover';

    /**
     * @var Build
     */
    protected $build;

    /**
     * @var bool|\SimpleXmlElement
     */
    protected $artifact;

    /**
     * @var array
     */
    protected $details = [];

    /**
     * {@inheritDoc}
     */
    public function parseArtifact(Build $build, $artifact)
    {
        $this->build = $build;
        $this->artifact = $artifact ? new \SimpleXMLElement($artifact) : false;

        $this->details['totalMethods'] = 0;
        $this->details['totalStatements'] = 0;
        $this->details['totalConditionals'] = 0;
        $this->details['coveredMethods'] = 0;
        $this->details['coveredStatements'] = 0;
        $this->details['coveredConditionals'] = 0;
        $this->details['total'] = 0;
        $this->details['covered'] = 0;

        if ($this->artifact) {
            foreach ($this->artifact->xpath('//file/class/metrics') as $metric) {
                $this->details['totalMethods'] += (int)$metric['methods'];
                $this->details['totalStatements'] += (int)$metric['statements'];
                $this->details['totalConditionals'] += (int)$metric['conditionals'];
                $this->details['coveredMethods'] += (int)$metric['coveredmethods'];
                $this->details['coveredStatements'] += (int)$metric['coveredstatements'];
                $this->details['coveredConditionals'] += (int)$metric['coveredconditionals'];

                $this->details['total'] += (int)$metric['methods'] + (int)$metric['statements'] +
                    (int)$metric['conditionals'];
                $this->details['covered'] += (int)$metric['coveredmethods'] + (int)$metric['coveredstatements'] +
                    (int)$metric['coveredconditionals'];
            }
        }

        $this->calculateTotals();

        if ($build->getParent()) {
            $parent = $build->getParent();
            $statistics = $parent->getFlatStatistics();

            $this->generateCoverageComparisonStatistics($statistics);
        }
    }

    /**
     * Calculate build statistic totals.
     */
    protected function calculateTotals()
    {
        $this->details['coverageMethods'] = $this->formatTotals(
            $this->details,
            'coveredMethods',
            'totalMethods'
        );

        $this->details['coverageStatement'] = $this->formatTotals(
            $this->details,
            'coveredStatements',
            'totalStatements'
        );

        $this->details['coverageConditions'] = $this->formatTotals(
            $this->details,
            'coveredConditions',
            'totalConditions'
        );

        $this->details['coverage'] = $this->formatTotals($this->details, 'coverage', 'total');
    }

    /**
     * Calculate coverage statistics against the parent build.
     *
     * @param array $statistics
     */
    protected function generateCoverageComparisonStatistics(array $statistics)
    {
        if (isset($statistics['method-coverage'])) {
            $this->details['methodCoverageChange'] =
                $this->details['coverageMethods'] - $statistics['method-coverage'];
        }

        if (isset($statistics['statement-coverage'])) {
            $this->details['statementCoverageChange'] =
                $this->details['coverageStatements'] - $statistics['statement-coverage'];
        }

        if (isset($statistics['conditional-coverage'])) {
            $this->details['conditionalCoverageChange'] =
                $this->details['coverageConditionals'] - $statistics['conditional-coverage'];
        }

        if (isset($statistics['total-coverage'])) {
            $this->details['totalCoverageChange'] =
                $this->details['coverage'] - $statistics['total-coverage'];
        }
    }

    /**
     * @param array $details
     * @param string $metric
     * @param string $total
     * @return float|int
     */
    protected function formatTotals(array $details, $metric, $total)
    {
        if ($details[$total] > 0) {
            return round($details[$metric] / $details[$total] * 100, 2);
        }

        return 0;
    }

    /**
     * {@inheritDoc}
     */
    public function getSimpleTextResult()
    {
        $result = "Code Coverage: " . number_format($this->details['coverage'], 2) . "%\n";

        if (isset($this->details['totalCoverageChange'])) {
            $result .= "Coverage Change: " . number_format($this->details['totalCoverageChange'], 2) . "%\n";
        }

        return $result;
    }

    /**
     * @param Build $build
     */
    public function generateBuildStatistics(Build $build)
    {
        $statistic = new Build\Statistic();
        $statistic->setName('method-coverage')->setValue($this->details['coveredMethods']);
        $build->addStatistic($statistic);

        $statistic = new Build\Statistic();
        $statistic->setName('statement-coverage')->setValue($this->details['coverageStatements']);
        $build->addStatistic($statistic);

        $statistic = new Build\Statistic();
        $statistic->setName('conditional-coverage')->setValue($this->details['coverageConditionals']);
        $build->addStatistic($statistic);

        $statistic = new Build\Statistic();
        $statistic->setName('total-coverage')->setValue($this->details['coverage']);
        $build->addStatistic($statistic);

        if ($build->getParent()) {
            if (isset($this->details['methodCoverageChange'])) {
                $statistic = new Build\Statistic();
                $statistic->setName('method-coverage-change');
                $statistic->setValue($this->details['methodCoverageChange']);
                $build->addStatistic($statistic);
            }

            if (isset($this->details['statementCoverageChange'])) {
                $statistic = new Build\Statistic();
                $statistic->setName('statement-coverage-change');
                $statistic->setValue($this->details['statementCoverageChange']);
                $build->addStatistic($statistic);
            }

            if (isset($this->details['conditionalCoverageChange'])) {
                $statistic = new Build\Statistic();
                $statistic->setName('conditional-coverage-change');
                $statistic->setValue($this->details['conditionalCoverageChange']);
                $build->addStatistic($statistic);
            }

            if (isset($this->details['totalCoverageChange'])) {
                $statistic = new Build\Statistic();
                $statistic->setName('total-coverage-change');
                $statistic->setValue($this->details['totalCoverageChange']);
                $build->addStatistic($statistic);

                $alert = new Build\Alert();
                $message = 'Code Coverage %s by ' . number_format(abs($this->details['totalCoverageChange']), 2) . '%%';

                if ($this->details['totalCoverageChange'] < 0) {
                    $alert->setType('warning');
                    $alert->setDescription(sprintf($message, 'Decreased'));
                } elseif ($this->details['totalCoverageChange'] > 0) {
                    $alert->setType('success');
                    $alert->setDescription(sprintf($message, 'Increased'));
                } else {
                    $alert->setType('info');
                    $alert->setDescription('Code Coverage Remained the Same');
                }

                $build->addAlert($alert);
            }
        }
    }
}
