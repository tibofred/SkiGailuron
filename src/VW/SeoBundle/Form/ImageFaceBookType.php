<?php



namespace VW\SeoBundle\Form;



use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\FileType;

use Symfony\Component\OptionsResolver\OptionsResolver;



class ImageFaceBookType extends AbstractType

{

    /**

     * {@inheritdoc}

     */

    public function buildForm(FormBuilderInterface $builder, array $options)

    {

        $builder

            ->add('file', FileType::class)

            ;

    }

    

    /**

     * {@inheritdoc}

     */

    public function configureOptions(OptionsResolver $resolver)

    {

        $resolver->setDefaults(array(

            'data_class' => 'VW\SeoBundle\Entity\ImageFaceBook'

        ));

    }



    /**

     * {@inheritdoc}

     */

    public function getBlockPrefix()

    {

        return 'vw_seobundle_imagefacebook';

    }





}

