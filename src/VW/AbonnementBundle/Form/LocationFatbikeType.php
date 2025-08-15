<?php

namespace VW\AbonnementBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class LocationFatbikeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $typeChoices = [
            '3' => 'Vélo Fat bike',
            '6' => 'Vélo électrique'
        ];
        $builder
            ->add('sport', EntityType::class, array(
                    'class'        => 'VWAbonnementBundle:Sport',
                    'choice_label' => 'nom',
                    'multiple'     => false,
                  ))
            ->add('duree', EntityType::class, array(
                    'class'        => 'VWAbonnementBundle:Duree',
                    'choice_label' => 'nom',
                    'multiple'     => false,
                  ))
            ->add('prix')
            ->add('ajouter', SubmitType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'VW\AbonnementBundle\Entity\LocationFatbike'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'vw_abonnementbundle_LocationFatbike';
    }


}
