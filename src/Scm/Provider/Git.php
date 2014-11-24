<?php

namespace Martha\Core\Scm\Provider;

/**
 * Class Git
 * @package Martha\Scm\Provider
 */
class Git extends AbstractProvider
{
    /**
     * @param string $cloneToPath
     * @return boolean
     */
    public function cloneRepository($cloneToPath)
    {
        $command = 'git clone ' . $this->repository . ' ' . $cloneToPath;
        return $this->environment->runCommand($command);
    }

    /**
     * @param string $ref
     * @return bool
     */
    public function checkout($ref)
    {
        $command = 'cd ' . $this->repository . ' && ' .
            'git checkout ' . $ref;

        return $this->environment->runCommand($command);
    }

    /**
     * @return array
     */
    public function getBranches()
    {
        return [];
    }

    /**
     * @todo switch to symfony process
     * @param string $startingCommit
     * @return array
     */
    public function getHistory($startingCommit = '')
    {
        $command = 'cd ' . $this->repository . ' && git log --pretty=format:"%H" -n 100 --skip 1 ' . $startingCommit;

        exec($command, $commits);

        return $commits;
    }
}
