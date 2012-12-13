<?php

namespace Herzult\Bundle\ForumBundle\Entity;

use Herzult\Bundle\ForumBundle\Model\CategoryRepositoryInterface;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
class CategoryRepository extends ObjectRepository implements CategoryRepositoryInterface
{
    /**
     * @see CategoryRepositoryInterface::findOneBySlug
     */
    public function findOneBySlug($slug)
    {
        return $this->findOneBy(array('slug' => $slug));
    }

    /**
     * @see CategoryRepositoryInteface::findAll
     */
    public function findAll()
    {
        return $this->createQueryBuilder('c')
            ->select('c')
            ->orderBy('c.position')
            ->getQuery()
            ->execute();
    }

    /**
     * @see CategoryRepositoryInterface::findAllIndexById
     */
    public function findAllIndexById()
    {
        return $this->getObjectManager()
            ->createQuery(sprintf('SELECT category FROM %s category INDEX BY category.id ORDER BY category.position', $this->getObjectClass()))
            ->execute();
    }

    public function findAllByForum($forum, $asPaginator = false)
    {
        $qb = $this->createQueryBuilder('category')
            ->orderBy('category.createdAt')
            ->where('category.forum = :forum')
            ->setParameter('forum', $forum->getId());

        if ($asPaginator) {
            return new Pagerfanta(new DoctrineORMAdapter($qb->getQuery()));
        }

        return $qb->getQuery()->execute();
    }
}
