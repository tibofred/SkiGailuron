<?php



namespace VW\SoumissionBundle\Form;



use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use VW\SoumissionBundle\Form\SoumissionType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;

use Symfony\Component\Form\Extension\Core\Type\TextType;

use VW\ClientBundle\Form\ClientSoumissionType;

use Symfony\Component\Form\FormEvent;

use Symfony\Component\Form\FormEvents;





class SoumissionType extends AbstractType

{

    /**

     * {@inheritdoc}

     */

    public function buildForm(FormBuilderInterface $builder, array $options)

    {

        $builder

            ->add('langue', ChoiceType::class, array(

        'choices'  => array(

            'Fraçais' => 'fr',

            'Anglais' => 'en',

            'Français et anglais' => 'fr-en',

            ),

            ))

            ->add('nbPages')

            ->add('urlDemo')

            ->add('ecommerce')

            ->add('client', ClientSoumissionType::class)

            ->add('tempsFonction')

            ->add('pourquoiSite', ChoiceType::class, array(

                'choices'  => array(

                'Parce que les gens autour de moi me suggère fortement d\'avoir un site internet' => 'Parce que les gens autour de moi me suggère fortement d\'avoir un site internet',

                'Parce que j\'ai besoin d\'un site internet pour mon entreprise : il sera un outil pour celle-ci' => 'Parce que j\'ai besoin d\'un site internet pour mon entreprise : il sera un outil pour celle-ci',

                'Parce que je veux avoir une visibilité sur le web lorsque les gens chercheront  le nom de mon entreprise - site vitrine -' => 'Parce que je veux avoir une visibilité sur le web lorsque les gens chercheront  le nom de mon entreprise - site vitrine -',

                'Parce que j\'espère que la création de mon site fera augmenter mon chiffre d\'affaire' => 'Parce que j\'espère que la création de mon site fera augmenter mon chiffre d\'affaire, ',

                ),

                'expanded'  => true,

                ))

            ->add('considerezSite', ChoiceType::class, array(

                'choices' => array(

                 

                    'Je considère un site Internet comme une simple vitrine avec le moin d\'entretien possible' => 'Je considère un site Internet comme une simple vitrine avec le moin d\'entretien possible',

                     'Je considère un site Internet comme un élément important de l\'entreprise qui demande de l\'entretien' => 'Je considère un site Internet comme un élément important de l\'entreprise qui demande de l\'entretien',

                 ),

                

                'expanded' => true,

            ))

            ->add('tempsSite', ChoiceType::class, array(

                'choices' => array(

                 

                    'Cet outil servira à mon entreprise, j\'irai au minimum 1 x par jour' => 'Cet outil servira à mon entreprise, j\'irai au minimum 1 x par jour',

                    'Je vais y aller (1-2 x semaine)' => 'Je vais y aller (1-2 x semaine)',

                    'Je vais y aller (1-2 x mois)' => 'Je vais y aller (1-2 x mois)',

                    'Je n\'aurai pas le temps de m\'en occuper' => 'Je n\'aurai pas le temps de m\'en occuper',

                 ),

                

                'expanded' => true,

            ))

            ->add('finSite', ChoiceType::class, array(

                'choices' => array(

                 

                    'Avoir un site fonctionnel à mon image actuel' => 'Avoir un site fonctionnel à mon image actuel',

                    'Avoir un site fonctionnel à mon image actuel et ne plus avoir à demander les services de mon conseillé web' => 'Avoir un site fonctionnel à mon image actuel et ne plus avoir à demander les services de mon conseillé web',

                    'Avoir un site fonctionnel à mon image actuel et être bien référencé sur la première page lors de recherches sur internet' => 'Avoir un site fonctionnel à mon image actuel et être bien référencé sur la première page lors de recherches sur internet',

                 ),

                

                'expanded' => true,

            ))

            ->add('importantSite', ChoiceType::class, array(

                'choices' => array(

                 

                    'D\'avoir un site internet original, hors du commun et qui représentera mon image corporative' => 'D\'avoir un site internet original, hors du commun et qui représentera mon image corporative',

                    'D\'avoir un site internet à mon image, fonctionnel et de faire un référencement minimum' => 'D\'avoir un site internet à mon image, fonctionnel et de faire un référencement minimum',

                    'D\'avoir un site internet simple, fonctionnel mais que le référencement de mon site soit très bien (soit sur la première page des recherches google)' => 'D\'avoir un site internet simple, fonctionnel mais que le référencement de mon site soit très bien (soit sur la première page des recherches google)',

                 ),

                

                'expanded' => true,

            ))

            ->add('competiteurs')

            ->add('outilsSite')

            ->add('champActivite')

            

            ->add('message')

            ->add('Envoyer',      SubmitType::class);

        

    }

    

    /**

     * {@inheritdoc}

     */

    public function configureOptions(OptionsResolver $resolver)

    {

        $resolver->setDefaults(array(

            'data_class' => 'VW\SoumissionBundle\Entity\Soumission'

        ));

    }



    /**

     * {@inheritdoc}

     */

    public function getBlockPrefix()

    {

        return 'vw_soumissionbundle_soumission';

    }





}

