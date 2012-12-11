<?php

namespace Herzult\Bundle\ForumBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('query', 'text');
    }

    /**
     * Sets the default options
     *
     * @param OptionsResolverInterface $resolver Options Resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'        => 'Herzult\Bundle\ForumBundle\Search\Search',
            'csrf_protection'   => false,
        ));
    }

    public function getName()
    {
        return 'Search';
    }
}
