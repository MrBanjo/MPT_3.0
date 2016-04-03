<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Adresse e-mail:',
                'invalid_message' => 'Cet Email est déjà utilisé.'
                ])
            ->add('password', RepeatedType::class, array(
                        'type' => PasswordType::class,
                        'invalid_message' => 'Les mots de passe doivent correspondre.',
                        'options' => array('required' => true),
                        'first_options' => array('label' => 'Mot de passe:','error_bubbling' => true),
                        'second_options' => array('label' => 'Confirmer ce mot de passe:'),
                        'error_bubbling' => true
                        ))
            ->add('civilite', ChoiceType::class, array(
                            'choices' => array(
                                'Mademoiselle' => 'Mademoiselle',
                                'Madame' => 'Madame',
                                'Monsieur' => 'Monsieur',
                                ),
                            'multiple' => false,
                            'expanded' => true,
                            'label' => 'Civilité:', ))
            ->add('prenom', TextType::class, array('label' => 'Prénom:'))
            ->add('nom', TextType::class, array('label' => 'Nom:'))
            ->add('birthdate', BirthdayType::class, array(
                                                    'widget' => 'choice',
                                                    'label' => 'Date de naissance:',
                                                    'format' => 'dd MMMM yyyy',
                                                    'years' => range(date('Y'), 1920), ))
            ->add('adresses', CollectionType::class, array(
                                                    'entry_type' => AdresseType::class,
                                                    'allow_add' => true,
                                                    'allow_delete' => true,
                                                    'by_reference' => false,
                                                    'label' => false,
                                                    ))
            ->add('VALIDER', SubmitType::class)
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User',
            'cascade_validation' => true,
        ));
    }
}
