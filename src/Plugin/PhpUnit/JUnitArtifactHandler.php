<?php

namespace Martha\Plugin\PhpUnit;

use Martha\Core\Domain\Entity\Build;
use Martha\Core\Plugin\AbstractArtifactHandler;
use Martha\Core\Plugin\ArtifactHandlers\TextBasedResultInterface;

/**
 * Class JUnitArtifactHandler
 * @package Martha\Plugin\PhpCodeSniffer
 */
class JUnitArtifactHandler extends AbstractArtifactHandler implements TextBasedResultInterface
{
    /**
     * @var string
     */
    protected $name = 'phpunit-junit';

    /**
     * @var Build
     */
    protected $build;

    /**
     * @var bool|\SimpleXmlElement
     */
    protected $artifact;

    /**
     * {@inheritDoc}
     */
    public function parseArtifact(Build $build, $artifact)
    {
        $this->build = $build;
        $this->artifact = $artifact ? new \SimpleXMLElement($artifact) : false;
    }

    /**
     * {@inheritDoc}
     */
    public function getSimpleTextResult()
    {
        $totalTests = 0;
        $totalAssertions = 0;
        $totalFailures = 0;
        $totalErrors = 0;

        if ($this->artifact) {
            foreach ($this->artifact->xpath('//testsuite') as $suite) {
                $totalTests += (int)$suite['tests'];
                $totalAssertions += (int)$suite['assertions'];
                $totalFailures += (int)$suite['failures'];
                $totalErrors += (int)$suite['errors'];
            }
        }

        $result = 'PHPUnit tests ' . ($totalErrors + $totalFailures > 0 ? 'failed' : 'passed') . ".\n\n" .
            "Tests: " . $totalTests . "\n" .
            "Assertions: " . $totalAssertions . "\n" .
            "Failures: " . $totalFailures . "\n" .
            "Errors: " . $totalErrors . "\n";

        return $result;
    }
}
