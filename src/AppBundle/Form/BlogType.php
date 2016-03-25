<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BlogType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('article')
            ->add('image')
            ->add('date','birthday', array( 'widget' => 'choice', 'label' => 'Date de parution:', 'format' => 'dd MMMM yyyy', 'years' => range(date('Y'),1920)))
            ->add('rubriqueblog', 'entity',array(
                'class' => 'AppBundle:Rubriqueblog',
                'property' => 'nom',
                'label' => 'Rubrique du blog:'
            ))
            ->add('Ajouter', 'submit', array( 'attr' => array("class" => "btn btn-default")))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Blog'
        ));
    }
}
