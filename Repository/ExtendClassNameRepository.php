<?php

namespace Plugin\ColorThumb\Repository;

use Eccube\Repository\AbstractRepository;
use Plugin\ColorThumb\Entity\ExtendClassCategory;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Eccube\Repository\ClassCategoryRepository;
use Eccube\Repository\ClassNameRepository;

/**
 * ExtendClassNameRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ExtendClassNameRepository extends ClassNameRepository
{
    /**
     * ExtendClassNameRepository constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ExtendClassCategory::class);
    }

    /**
     * @param int $id
     *
     * @return null|ExtendClassCategory
     */
    public function get($id = 1)
    {
        return $this->find($id);
    }
}
