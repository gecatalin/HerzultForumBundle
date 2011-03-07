<?php

namespace Bundle\ForumBundle\Router;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Bundle\ForumBundle\Model\Category;
use Bundle\ForumBundle\Model\Topic;
use Bundle\ForumBundle\Model\Post;

class ForumUrlGenerator
{
    protected $container;
    protected $nbPostsPerPage;

    public function __construct(ContainerInterface $container, $nbPostsPerPage)
    {
        $this->container = $container;
        $this->nbPostsPerPage = $nbPostsPerPage;
    }

    public function urlForCategory(Category $category, $absolute = false)
    {
        return $this->container->get('router')->generate('forum_category_show', array(
            'slug' => $category->getSlug()
        ), $absolute);
    }

    public function urlForCategoryAtomFeed(Category $category, $absolute = false)
    {
        return $this->container->get('router')->generate('forum_category_show', array(
            'slug'      => $category->getSlug(),
            '_format'   =>  'xml'
        ), $absolute);
    }

    public function urlForTopic(Topic $topic, $absolute = false)
    {
        return $this->container->get('router')->generate('forum_topic_show', array(
            'categorySlug'  => $topic->getCategory()->getSlug(),
            'slug'          => $topic->getSlug()
        ), $absolute);
    }

    public function urlForTopicAtomFeed(Topic $topic, $absolute = false)
    {
        return $this->container->get('router')->generate('forum_topic_show', array(
            'categorySlug'  => $topic->getCategory()->getSlug(),
            'slug'          => $topic->getSlug(),
            '_format'       => 'xml'
        ), $absolute);
    }

    public function urlForTopicReply(Topic $topic, $absolute = false)
    {
        return $this->container->get('router')->generate('forum_topic_post_new', array(
            'categorySlug'  => $topic->getCategory()->getSlug(),
            'slug'          => $topic->getSlug()
        ));
    }

    public function urlForPost(Post $post, $absolute = false)
    {
        $topicUrl = $this->urlForTopic($post->getTopic(), $absolute);
        $topicPage = ceil($post->getNumber() / $this->nbPostsPerPage);

        return sprintf('%s?page=%d#%d', $topicUrl, $topicPage, $post->getNumber());
    }

    public function getTopicNumPages(Topic $topic)
    {
        return ceil($topic->getNumPosts() / $this->nbPostsPerPage);
    }
}
