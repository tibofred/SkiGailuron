<?php



namespace VW\ClientBundle\Form;



use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;

use Symfony\Component\Form\Extension\Core\Type\TextType;





class VilleType extends AbstractType

{

    /**

     * {@inheritdoc}

     */

    public function buildForm(FormBuilderInterface $builder, array $options)

    {

        $builder

            ->add('nom')

            ->add('region')

            ->add('slug')

            ->add('contenu', CKEditorType::class, array(

            'config' => array(

                'uiColor' => '#ffffff',

            ),

        ))

            ->add('save', SubmitType::class);

        

    }

    

    /**

     * {@inheritdoc}

     */

    public function configureOptions(OptionsResolver $resolver)

    {

        $resolver->setDefaults(array(

            'data_class' => 'VW\ClientBundle\Entity\Ville'

        ));

    }



    /**

     * {@inheritdoc}

     */

    public function getBlockPrefix()

    {

        return 'vw_clientbundle_ville';

    }





}

