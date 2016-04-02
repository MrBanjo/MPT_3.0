<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BlogType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('description', TextType::class)
            ->add('article')
            ->add('image')
            ->add('date', BirthdayType::class, [
                'widget' => 'choice', 
                'label' => 'Date de parution:', 
                'format' => 'dd MMMM yyyy', 
                'years' => range(date('Y'), 1920)
            ])
            ->add('rubriqueblog', EntityType::class, [
                'class' => 'AppBundle:Rubriqueblog',
                'choice_label' => 'nom',
                'label' => 'Rubrique du blog:',
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
            'data_class' => 'AppBundle\Entity\Blog',
        ));
    }
}
