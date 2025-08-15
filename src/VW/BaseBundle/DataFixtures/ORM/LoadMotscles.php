<?php

// src/VW/BaseBundle/DataFixtures/ORM/LoadMotscles.php



namespace VW\BaseBundle\DataFixtures\ORM;



use Doctrine\Common\DataFixtures\FixtureInterface;

use Doctrine\Common\Persistence\ObjectManager;

use VW\SeoBundle\Entity\Motscles;



class LoadMotscles implements FixtureInterface

{

  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager

  public function load(ObjectManager $manager)

  {

    // Liste des noms de catégorie à ajouter

    $motscles = array(

      'Développement web',

      'Développement mobile',

      'Graphisme',

      'Intégration',

      'Réseau'

    );



    foreach ($motscles as $motcle) {

      // On crée la catégorie

      $motcle = new Motscles();

      $motcle->setMotcle($motcle);



      // On la persiste

      $manager->persist($motcle);

    }



    // On déclenche l'enregistrement de toutes les catégories

    $manager->flush();

  }

}