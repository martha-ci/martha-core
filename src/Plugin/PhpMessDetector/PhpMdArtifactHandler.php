<?php

namespace Martha\Plugin\PhpMessDetector;

use Martha\Core\Domain\Entity\Build;
use Martha\Core\Plugin\AbstractArtifactHandler;
use Martha\Core\Plugin\ArtifactHandlers\TextBasedResultInterface;

/**
 * Class PhpMdArtifactHandler
 * @package Martha\Plugin\PhpMessDetector
 */
class PhpMdArtifactHandler extends AbstractArtifactHandler implements TextBasedResultInterface
{
    /**
     * @var string
     */
    protected $name = 'phpmd';

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
        $violationCount = 0;

        if ($this->artifact) {
            foreach ($this->artifact->xpath('//file') as $file) {
                foreach ($file->xpath('//violation') as $violation) {
                    $violationCount++;
                }
            }

            $result = $violationCount . ' instance' . ($violationCount > 1 ? 's ' : ' ') .
                "of messy code found\n";
        } else {
            $result = "No Messy Code Detected\n";
        }

        return $result;
    }
}
