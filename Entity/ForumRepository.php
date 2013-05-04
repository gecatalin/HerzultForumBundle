<?php

namespace Herzult\Bundle\ForumBundle\Entity;

use Herzult\Bundle\ForumBundle\Model\ForumRepositoryInterface;
use Symfony\Component\Security\Core\Util\ClassUtils;
class ForumRepository extends ObjectRepository implements ForumRepositoryInterface
{
	public function findAllByOwner($owner, $asPaginator = false)
    {
    	$class = new ClassUtils();
    	$class = $class->getRealClass($owner);
        $qb = $this->createQueryBuilder('forum')
            ->where('forum.objectEntityId = :forumId')
            ->where('forum.objectEntityClass = :forumClass')
            ->setParameter('forumId', $owner->getId())
            ->setParameter('forumClass', $class);

        if ($asPaginator) {
            return new Pagerfanta(new DoctrineORMAdapter($qb->getQuery()));
        }
        return $qb->getQuery()->execute();
    }
}

