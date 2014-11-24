<?php

namespace Martha\Core\Service\Logger;

use Martha\Core\Domain\Entity\Log;
use Martha\Core\Domain\Repository\LogRepositoryInterface;
use Psr\Log\AbstractLogger;

/**
 * Class DatabaseLogger
 * @package Martha\Core\Service\Logger
 */
class DatabaseLogger extends AbstractLogger
{
    /**
     * @var LogRepositoryInterface
     */
    protected $logRepository;

    /**
     * @param LogRepositoryInterface $errorRepo
     */
    public function __construct(LogRepositoryInterface $errorRepo)
    {
        $this->logRepository = $errorRepo;
    }

    /**
     * {@inheritDoc}
     */
    public function log($level, $message, array $context = [])
    {
        $log = new Log();
        $log->setLevel($level);
        $log->setMessage($message);
        $log->setCreated(new \DateTime());

        $this->logRepository->persist($log)->flush();
    }
}
