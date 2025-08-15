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

class TarifType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sport', EntityType::class, array(
                    'class'        => 'VWAbonnementBundle:Sport',
                    'choice_label' => 'nom',
                    'multiple'     => false,
                  ))
            ->add('categorie', EntityType::class, array(
                    'class'        => 'VWAbonnementBundle:Categorie',
                    'choice_label' => 'nom',
                    'multiple'     => false,
                  ))
            ->add('prix_semaine')
            ->add('prix_fin_de_semaine')
            ->add('ajouter', SubmitType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'VW\AbonnementBundle\Entity\Tarif'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'vw_abonnementbundle_Tarif';
    }


}
