<?php

namespace Herzult\Bundle\ForumBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Herzult\Bundle\ForumBundle\Model\CategoryRepositoryInterface;

class NewTopicFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('subject');
        $builder->add('category');
        $builder->add('firstPost', $options['post_form'], array('data_class' => $options['post_class']));
    }

    /**
     * Sets the default options
     *
     * @param OptionsResolverInterface $resolver Options Resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'post_class'    => '',
            'post_form'     => '',
            'data_class'    => '',
        ));
    }

    public function getName()
    {
        return 'NewTopic';
    }
}
