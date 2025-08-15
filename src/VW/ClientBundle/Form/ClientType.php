<?php



namespace VW\ClientBundle\Form;



use VW\ClientBundle\Repository\VilleRepository;

use VW\ClientBundle\Repository\CategorieRepository;

use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\Extension\Core\Type\TextType;

use VW\RealisationBundle\Form\RealisationType;

use Symfony\Component\Form\FormEvent;

use Symfony\Component\Form\FormEvents;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;







class ClientType extends AbstractType

{

    /**

     * {@inheritdoc}

     */

    public function buildForm(FormBuilderInterface $builder, array $options)

    {

        

        $pattern = '%';

        

        $builder

            ->add('prenom')

            ->add('nom')

            ->add('courriel')

            ->add('telephone')

            ->add('adresse', TextType::class, array('required' => false))

            ->add('codepostal', TextType::class, array('required' => false))

            ->add('ville')

            ->add('province', TextType::class, array('required' => false))

            ->add('pays');

    }

    

    /**

     * {@inheritdoc}

     */

    public function configureOptions(OptionsResolver $resolver)

    {

        $resolver->setDefaults(array(

            'data_class' => 'VW\ClientBundle\Entity\Client'

        ));

    }



    /**

     * {@inheritdoc}

     */

    public function getBlockPrefix()

    {

        return 'vw_clientbundle_client';

    }





}

