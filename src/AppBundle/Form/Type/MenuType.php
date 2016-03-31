<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MenuType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('prix')
            ->add('photo')
            ->add('date')
            ->add('active')
            ->add('categorie', 'entity', array(
                'class' => 'AppBundle:Categorie',
                'property' => 'nom',
            ))
            ->add('plats', 'entity', array(
                'class' => 'AppBundle:Plat',
                'property' => 'titre',
                'multiple' => 'true',
            ))
            ->add('Ajouter', 'submit', array('attr' => array('class' => 'btn btn-default')))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Menu',
        ));
    }
}
