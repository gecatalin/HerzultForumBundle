<?php

namespace Herzult\Bundle\ForumBundle\Remover;
use Herzult\Bundle\ForumBundle\Remover\CategoryRemover;
use Herzult\Bundle\ForumBundle\Model\Forum;
use Herzult\Bundle\ForumBundle\Model\CategoryRepositoryInterface;
use Herzult\Bundle\ForumBundle\Updater\CategoryUpdater;
use LogicException;

class ForumRemover
{
    protected $objectManager;
    protected $categoryRepository;
    protected $categoryRemove;

    public function __construct($objectManager, CategoryRemover $categoryRemover, CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRemover = $categoryRemover;
        $this->objectManager   = $objectManager;
        $this->categoryRepository = $categoryRepository;
       
    }

    public function remove(Forum $forum)
    {

        foreach ($this->getForumCategories($category) as $category) {
            $this->categoryRemover->remove($category);
        }
        $this->objectManager->remove($forum);
        $this->objectManager->flush();
    }

    protected function getForumCategories(Forum $forum)
    {
        return $this->categoryRepository->findAllByForum($forum);
    }
}
