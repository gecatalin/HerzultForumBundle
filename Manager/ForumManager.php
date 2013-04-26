<?php
namespace Herzult\Bundle\ForumBundle\Manager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Herzult\Bundle\ForumBundle\Entity\Forum;
use Herzult\Bundle\ForumBundle\Entity\Category;
use Herzult\Bundle\ForumBundle\Entity\Topic;
use Herzult\Bundle\ForumBundle\Entity\Post;
use Herzult\Bundle\ForumBundle\Remover\ForumRemover;
use Herzult\Bundle\ForumBundle\Remover\CategoryRemover;
use Herzult\Bundle\ForumBundle\Remover\PostRemover;
use Herzult\Bundle\ForumBundle\Remover\TopicRemover;
use Symfony\Component\Security\Core\Util\ClassUtils;

class ForumManager 
{
    /**
     * @var ObjectManager
     */
    protected $em;
    protected $classname;
    protected $forumRemover;
    protected $categoryRemover;
    protected $topicRemover;
    protected $postRemover;
    /**
     * @param ObjectManager $em        Object manager service
     * @param string        $repository Repository name
     */
    public function __construct(EntityManager $em, $repository, ForumRemover $forumRemover, CategoryRemover $categoryRemover, TopicRemover $topicRemover, PostRemover $postRemover)
    {
        $this->classname = new ClassUtils();
        $this->em         = $em;
        $this->repository = $repository;
        $this->forumRemover = $forumRemover;
        $this->categoryRemover = $categoryRemover;
        $this->topicRemover = $topicRemover;
        $this->postRemover = $postRemover;
    }

    public function newForum($owner)
    {   
        $forum = new Forum();
        $forum->setOwningEntityId($owner->getId());
        $forum->setOwningEntityClass($this->classname->getRealClass($owner));
        return $forum;
    }
    public function persistForum(Forum $forum)
    {
        $this->em->persist($forum);
        $this->em->flush();
    }
    public function getForumOwnerObject(Forum $forum)
    {
        $owner = $forum->getOwningEntity();
        $ownerObject = $this->__buildObject($forum->getOwningEntityClass(),$forum->getOwningEntityId());
        return $ownerObject;
    }
    public function removeForum(Forum $forum){
        $this->forumRemover->remove($forum);
    }
    public function removeCategory(Category $category){
        $this->categoryRemover->remove($category);
    }
    public function removeTopic(Topic $topic){
        $this->topicRemover->remove($topic);
    }
    public function removePost(Post $post){
        $this->postRemover->remove($post);
    }
    public function getForumByOwner($owner){
        return $this->__getRepository()->findAllByOwner($owner);
    }
    private function __buildObject($className, $id)
    {
        return $this->em->getRepository($className)->findOneById($id);
    }

    /**
     * Get entity repository.
     *
     * @return EntityRepository
     */
    private function __getRepository()
    {
        return $this->em->getRepository($this->repository);
    }
}
