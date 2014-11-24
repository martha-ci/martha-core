<?php

namespace Martha\Core\Persistence\Repository\Test\PHPUnit;

use PHPUnit_Framework_MockObject_MockObject;

/**
 * Class AbstractRepositoryTest
 * @package Martha\Core\Persistence\Repository\Test\PHPUnit
 */
class AbstractRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * The entity class that is of relevance to this test case.
     * @var string
     */
    protected $testEntity = null;

    /**
     * The repository class that is of relevance to this test case.
     * @var string
     */
    protected $testRepository = null;

    /**
     * The mocked entity manager.
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $entityManager;

    /**
     * The mocked Doctrine EntityRepository.
     * @var \Martha\Core\Persistence\Repository\AbstractRepository
     */
    protected $repository;

    /**
     * Setup the test suite by verifying the configuration of the test class, mocking Doctrine's EntityManager, and
     * setting up the defined repository for the test cases.
     */
    public function setUp()
    {
        if (!isset($this->testRepository)) {
            $this->markTestIncomplete('No testRepository specified');
            return;
        }

        if (!isset($this->testEntity)) {
            $this->markTestIncomplete('No testEntity specified');
            return;
        }

        $this->entityManager = $this->getMock(
            '\Doctrine\ORM\EntityManager',
            [],
            [],
            '',
            false
        );

        $this->repository = new $this->testRepository($this->entityManager);
    }

    /**
     * Test the persist method of the repository to ensure that it properly interacts with Doctrine.
     */
    public function testPersist()
    {
        $entity = $this->getMock($this->testEntity);

        $this->entityManager
            ->expects($this->once())
            ->method('persist')
            ->with($entity);

        $this->repository->persist($entity);
    }

    /**
     * Test the flush method of the repository to ensure that it properly interacts with Doctrine.
     */
    public function testFlush()
    {
        $entity = $this->getMock($this->testEntity);

        $this->entityManager
            ->expects($this->once())
            ->method('flush')
            ->with($entity);

        $this->repository->flush($entity);
    }

    /**
     * Test that getById() properly interacts with Doctrine.
     */
    public function testGetById()
    {
        $this->entityManager
            ->expects($this->once())
            ->method('find')
            ->with($this->testEntity, 5);

        $this->repository->getById(5);
    }

    /**
     * Test that the repository's getAll() method calls the Doctrine EntityRepository's findAll()
     */
    public function testGetAll()
    {
        $mockRepository = $this->getMockEntityRepository();
        $mockRepository->expects($this->once())->method('findAll');

        $this->repository->getAll();
    }

    /**
     * Test that the repository's getBy() method calls the Doctrine EntityRepository's findBy()
     */
    public function testGetBy()
    {
        $criteria = ['foo' => 'bar'];
        $orderBy = ['bum', 'asc'];
        $limit = 20;
        $offset = 400;

        $mockRepository = $this->getMockEntityRepository();
        $mockRepository->expects($this->once())
            ->method('findBy')
            ->with($criteria, $orderBy, $limit, $offset);

        $this->repository->getBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * Test that a proper DomainException is thrown when passing the wrong entity type to the repository class.
     */
    public function testWrongEntityTypePassed()
    {
        $this->setExpectedException('DomainException');

        $entity = $this->getMockForAbstractClass('\Martha\Core\Domain\Entity\AbstractEntity');

        $this->repository->persist($entity);
    }

    /**
     * Test that a proper DomainException is thrown when instantiating a Repository without an entity class specified.
     */
    public function testNonExistentEntityType()
    {
        $this->setExpectedException('DomainException');

        $this->getMockForAbstractClass(
            '\Martha\Core\Persistence\Repository\AbstractRepository',
            [$this->entityManager]
        );
    }

    /**
     * Builds a mock Doctrine\ORM\EntityRepository, configures $this->entityManager to return it when calling
     * getRepository(), and returns the repository for further mocking.
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockEntityRepository()
    {
        $mockRepository = $this->getMock('\Doctrine\ORM\EntityRepository', [], [], '', false);

        $this->entityManager
            ->expects($this->once())
            ->method('getRepository')
            ->with($this->testEntity)
            ->will($this->returnValue($mockRepository));

        return $mockRepository;
    }
}
