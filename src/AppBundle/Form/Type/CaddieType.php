<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CaddieType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('session')
            ->add('quantite')
            ->add('prix')
            ->add('photo')
            ->add('titre')
            ->add('user')
            ->add('menu', EntityType::class, [
                'class' => 'AppBundle:Menu',
                'multiple' => false
            ])
            ->add('upsell', EntityType::class, [
                'class' => 'AppBundle:Upsell',
                'multiple' => false

            ])
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Caddie'
        ));
    }
}
