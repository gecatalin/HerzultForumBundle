<?php

namespace Herzult\Bundle\ForumBundle\Remover;
use Herzult\Bundle\ForumBundle\Remover\TopicRemover;
use Herzult\Bundle\ForumBundle\Model\Category;
use Herzult\Bundle\ForumBundle\Model\TopicRepositoryInterface;
use LogicException;

class CategoryRemover
{
    protected $objectManager;
    protected $topicRepository;
    protected $topicRemove;

    public function __construct($objectManager, TopicRemover $topicRemover, TopicRepositoryInterface $topicRepository)
    {
        $this->topicRemover = $topicRemover;
        $this->objectManager   = $objectManager;
        $this->topicRepository = $topicRepository;
       
    }

    public function remove(Category $category)
    {

        foreach ($this->getCategoryTopics($category) as $category) {
            $this->topicRemover->remove($category);
        }
        $this->objectManager->remove($category);
        $this->objectManager->flush();
    }

    protected function getCategoryTopics(Category $category)
    {
        return $this->topicRepository->findAllByCategory($category);
    }
}
