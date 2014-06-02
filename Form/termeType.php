<?php

namespace OVE\ThesaurusBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class termeType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id_thesaurus')
            ->add('terme')
            ->add('description')
            ->add('id_terme_parent');
            //->add('id_terme_associe')
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'OVE\ThesaurusBundle\Entity\terme'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ove_thesaurusbundle_terme';
    }
}
