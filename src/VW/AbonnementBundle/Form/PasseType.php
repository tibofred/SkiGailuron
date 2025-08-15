<?php

namespace VW\AbonnementBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PasseType extends AbstractType
{
    private $request_stack;

    public function __construct(RequestStack $request_stack)
    {
        $this->request_stack = $request_stack;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $locale = $this->request_stack->getCurrentRequest()->attributes->get('_locale');

        $builder
            ->add('type', EntityType::class, array(
                'class' => 'VWAbonnementBundle:TypeAbonnement',
                'choice_label' => ($locale == 'fr') ? 'nom' : 'nomEn',
                'multiple' => false,
            ))
            ->add('nom', TextType::class, array(
                'translation_domain' => 'nouveau',
                'attr' => array(
                    'class' => 'nom'
                ),
                'label' => 'Last_name'
            ))
            ->add('prenom', TextType::class, array(
                'translation_domain' => 'nouveau',
                'attr' => array(
                    'class' => 'prenom'
                ),
                'label' => 'First_name'
            ))
            ->add('dateAnniversaire', DateTimeType::class, array(
                'translation_domain' => 'nouveau',
                'widget' => 'single_text',
                'attr' => ['class' => 'js-datepicker'],
                'required' => false,
                'label' => 'Birthday'
            ))
            ->add('image', ImageType::class, array(
                'translation_domain' => 'nouveau',
                'label' => 'Your_photo'
            ))
            ->add('nomConjoint', TextType::class, array(
                'translation_domain' => 'nouveau',
                'label' => 'Conjoint_last_name'
            ))
            ->add('prenomConjoint', TextType::class, array(
                'translation_domain' => 'nouveau',
                'label' => 'Conjoint_first_name'
            ))
            ->add('dateAnniversaireConjoint', DateTimeType::class, array(
                'translation_domain' => 'nouveau',
                'label' => 'Conjoint_birthday',
                'widget' => 'single_text',
                'attr' => ['class' => 'js-datepicker'],
                'required' => false,
            ))
            ->add('imageConjoint', ImageType::class, array(
                'translation_domain' => 'nouveau',
                'label' => 'Conjoint_photo',
                'required' => false
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'VW\AbonnementBundle\Entity\Passe'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'vw_abonnementbundle_passe';
    }


}
