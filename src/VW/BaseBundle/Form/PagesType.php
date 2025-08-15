<?php

// src/VW/BaseBundle/Form/PageType.php



namespace VW\BaseBundle\Form;





use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;

use Symfony\Component\Form\Extension\Core\Type\TextType;



use VW\SeoBundle\Form\SeoType;



use VW\SeoBundle\Form\OpenGraphType;

use VW\SeoBundle\Form\ImageFaceBookType;



use Symfony\Component\Form\FormEvent;

use Symfony\Component\Form\FormEvents;





class PagesType extends AbstractType

{

    /**

     * {@inheritdoc}

     */

    public function buildForm(FormBuilderInterface $builder, array $options)

    {

        $builder

            ->add('url', TextType::class)

            ->add('titre', TextType::class)

            ->add('contenu', CKEditorType::class, array(

            'config' => array(

                'uiColor' => '#ffffff',

            ),

        ))

            ->add('seo', SeoType::class)

            ->add('opengraph', OpenGraphType::class, array('label' => 'Open Graph'))

            ->add('save', SubmitType::class, array('label' => 'Ajouter'));

    }

    



}

