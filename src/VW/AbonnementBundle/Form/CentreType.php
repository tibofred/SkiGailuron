<?php



namespace VW\AbonnementBundle\Form;



use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;



use Symfony\Component\Translation\Translator;

use Symfony\Component\Translation\Loader\ArrayLoader;



class CentreType extends AbstractType

{

    /**

     * {@inheritdoc}

     */

    public function buildForm(FormBuilderInterface $builder, array $options)

    {

        $builder->add('statut', ChoiceType::class, array(

                'translation_domain' => 'centre',

                'choices' => array(

                    'Ouvert' => true,

                    'Fermé' => false,

                ))

            )
            
            ->add('status_fatbike', ChoiceType::class, array(

                'translation_domain' => 'centre',

                'choices' => array(

                    'Ouvert' => true,

                    'Fermé' => false,

                ))

            )
            ->add('status_raquette', ChoiceType::class, array(

                'translation_domain' => 'centre',

                'choices' => array(

                    'Ouvert' => true,

                    'Fermé' => false,

                ))  

            )  
            
            ->add('qte_neige')
            ->add('annee', TextType::class,array('label' => 'Année'))
            ->add('date_neige', DateTimeType::class, array(

            'widget' => 'single_text',

            'attr' => ['class' => 'js-datepicker'],

            'required' => true,

            ))
            
            ->add('capacite', ChoiceType::class, array(
                
                'label' => 'Capacité atteinte',

                'choices' => array(

                    'Oui' => true,

                    'Non' => false,

                ))

        )

            ->add('Modifier', SubmitType::class,

                array(
                    'translation_domain' => 'centre',
                    'attr'=> array('class'=>'btn btn-success')
                )

            );

    }



    /**

     * {@inheritdoc}

     */

    public function configureOptions(OptionsResolver $resolver)

    {

        $resolver->setDefaults(array(

            'data_class' => 'VW\AbonnementBundle\Entity\Centre'

        ));

    }



    /**

     * {@inheritdoc}

     */

    public function getBlockPrefix()

    {

        return 'vw_abonnementbundle_centre';

    }





}