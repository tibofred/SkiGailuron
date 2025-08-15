<?php



namespace VW\AbonnementBundle\Form;



use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\FormEvent;

use Symfony\Component\Form\FormEvents;

use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Translation\Translator;

use Symfony\Component\Translation\Loader\ArrayLoader;





class SentierType extends AbstractType

{

    /**

     * {@inheritdoc}

     */

    public function buildForm(FormBuilderInterface $builder, array $options)

    {

       /* $request = $this->getRequest();

        $currentLocale = $request->getLocale();

        $locale = $this->get('session')->getLocale();

        $translator = new Translator($locale);

        $translated = $translator->trans(

            'field_name',

            array(),

            'sentier',

            'fr_FR'

        );*/



        $builder

              ->add('sport', EntityType::class, array(

                'choice_translation_domain' => 'sentier',

                'class' => 'VWAbonnementBundle:Sport',

                'choice_label' => 'nom',

                'multiple' => false,

            ))

            ->add('condition', EntityType::class, array(

                'class' => 'VWAbonnementBundle:Condition',

                'choice_label' => 'nom',

                'multiple' => false,

            ))

            ->add('nom')

            ->add('longueur')

            ->add('dernier_tracage', DateTimeType::class, array(

                'widget' => 'single_text',

                'attr' => ['class' => 'js-datepicker'],

                'required' => false,

            ))

            ->add('description', TextareaType::class, array(

                'required' => false,

            ))

            ->add('slug')
           

            ->add('statut', ChoiceType::class, array(

                'choices'  => array(

                    'Ouvert' => true,

                    'Fermé' => false,

                ))

            )

            ->add('difficulte', ChoiceType::class, array(

                'choices'  => array(

                    'Débutant' => 0,

                    'Intermédiaire' => 1,

                    'Expert' => 2,

                ))

            )

            ->add('ajouter', SubmitType::class);

    }

    

    /**

     * {@inheritdoc}

     */

    public function configureOptions(OptionsResolver $resolver)

    {

        $resolver->setDefaults(array(

            'data_class' => 'VW\AbonnementBundle\Entity\Sentier'

        ));

    }



    /**

     * {@inheritdoc}

     */

    public function getBlockPrefix()

    {

        return 'vw_abonnementbundle_sentier';

    }





}

