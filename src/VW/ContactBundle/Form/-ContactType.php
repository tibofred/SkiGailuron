<?php



namespace VW\ContactBundle\Form;



use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;



class ContactType extends AbstractType

{

    /**

     * {@inheritdoc}

     */

    public function buildForm(FormBuilderInterface $builder, array $options)

    {

        $builder

            ->add('name')

            ->add('email')

            ->add('phone')

            ->add('subject')

            ->add('message')

            ->add('date' )

            ;

    }

    

    /**

     * {@inheritdoc}

     */

    public function configureOptions(OptionsResolver $resolver)

    {

        $resolver->setDefaults(array(

            'data_class' => 'VW\ContactBundle\Entity\Contact'

        ));

    }



    /**

     * {@inheritdoc}

     */

    public function getBlockPrefix()

    {

        return 'vw_contactbundle_contact';

    }





}

