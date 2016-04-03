<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use AppBundle\Form\Type\CaddieType;

class CommandesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reference')
            ->add('status')
            ->add('quantite')
            ->add('prix')
            ->add('date', DateType::class)
/*            ->add('produit', CollectionType::class, array(
                                                    'entry_type' => CaddieType::class,
                                                    'allow_add' => true,
                                                    'allow_delete' => true,
                                                    'by_reference' => false,
                                                    'label' => false,
                                                    ))*/
            ->add('user')
            ->add('Modifier', SubmitType::class, ['attr' => ['class' => 'btn btn-default']])
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Commandes'
        ));
    }
}
