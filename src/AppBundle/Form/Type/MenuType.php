<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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
            ->add('categorie', EntityType::class, [
                'class' => 'AppBundle:Categorie',
                'choice_label' => 'nom',
            ])
            ->add('plats', EntityType::class, [
                'class' => 'AppBundle:Plat',
                'choice_label' => 'titre',
                'multiple' => 'true',
            ])
            ->add('Ajouter', SubmitType::class, ['attr' => ['class' => 'btn btn-default']])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Menu',
        ));
    }
}
