<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AdresseType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('voie', TextType::class, array('label' => 'N°, nom de la voie:'))
            ->add('complement', TextType::class, array('label' => "Bâtiment, code d'accès:", 'required' => false))
            ->add('postal', TextType::class, array('label' => 'Code Postal:'))
            ->add('ville', TextType::class, array('label' => 'Ville:'))
            ->add('titre', TextType::class, array('label' => 'Donnez un titre à cette adresse :'))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Adresse',
        ));
    }
}
