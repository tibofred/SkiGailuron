<?php

namespace VW\AbonnementBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\OptionsResolver\OptionsResolver;
use VW\AbonnementBundle\Entity\Passe;
use VW\ClientBundle\Form\ClientType;
use VW\AbonnementBundle\Form\PasseType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AbonnementType extends AbstractType
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
            ->add('client', ClientType::class)
            ->add('passe', CollectionType::class, array(
                'label' => false,
                'entry_type' => PasseType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'prototype' => true,
            ))
            ->add('Passer la commande', SubmitType::class, array(
                'translation_domain' => 'nouveau',
                'label' => 'Order_now',
                'attr' => array(
                    'class'=>'btn btn-success'
                )
            ));

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'VW\AbonnementBundle\Entity\Abonnement'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'vw_abonnementbundle_abonnement';
    }


}
