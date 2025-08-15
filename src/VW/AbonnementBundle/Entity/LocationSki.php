<?php



namespace VW\AbonnementBundle\Entity;



use Doctrine\ORM\Mapping as ORM;



/**

 * LocationSki

 *

 * @ORM\Table(name="prix_location_ski")

 * @ORM\Entity(repositoryClass="VW\AbonnementBundle\Repository\LocationSkiRepository")

 */

class LocationSki

{

    /**

     * @var int

     *

     * @ORM\Column(name="id", type="integer")

     * @ORM\Id

     * @ORM\GeneratedValue(strategy="AUTO")

     */

    private $id;



    /**

     * @ORM\ManyToOne(targetEntity="VW\AbonnementBundle\Entity\Categorie", cascade={"persist"},  fetch="EAGER")

     * @ORM\JoinColumn(nullable=false)

     */

    private $categorie;

    

    /**

     * @ORM\ManyToOne(targetEntity="VW\AbonnementBundle\Entity\Sport", cascade={"persist"},  fetch="EAGER")

     * @ORM\JoinColumn(nullable=false)

     */

    private $sport;

    

    /**

     * @var string

     *

     * @ORM\Column(name="prix_equipement_complet", type="decimal", precision=10, scale=2)

     */

    private $prix_equipement_complet;



    /**

     * @var string

     *

     * @ORM\Column(name="prix_ski_seulement", type="decimal", precision=10, scale=2)

     */

    private $prix_ski_seulement;



    /**

     * @var string

     *

     * @ORM\Column(name="prix_bottes_seulement", type="decimal", precision=10, scale=2)

     */

    private $prix_bottes_seulement;



    /**

     * @var string

     *

     * @ORM\Column(name="prix_batons_seulement", type="decimal", precision=10, scale=2)

     */

    private $prix_batons_seulement;



    /**

     * Get id

     *

     * @return int

     */

    public function getId()

    {

        return $this->id;

    }



    /**

     * Set categorie

     *

     * @param \VW\AbonnementBundle\Entity\Categorie $categorie

     *

     * @return Tarif

     */

    public function setCategorie(\VW\AbonnementBundle\Entity\Categorie $categorie)

    {

        $this->categorie = $categorie;



        return $this;

    }



    /**

     * Get categorie

     *

     * @return \VW\AbonnementBundle\Entity\Categorie

     */

    public function getCategorie()

    {

        return $this->categorie;

    }



    /**

     * Set sport

     *

     * @param \VW\AbonnementBundle\Entity\Sport $sport

     *

     * @return Tarif

     */

    public function setSport(\VW\AbonnementBundle\Entity\Sport $sport)

    {

        $this->sport = $sport;



        return $this;

    }



    /**

     * Get sport

     *

     * @return \VW\AbonnementBundle\Entity\Sport

     */

    public function getSport()

    {

        return $this->sport;

    }



    /**

     * Set prix_equipement_complet

     *

     * @param string $prix_equipement_complet

     *

     * @return Tarif

     */

    public function setPrixEquipementComplet($prix_equipement_complet)

    {

        $this->prix_equipement_complet = $prix_equipement_complet;



        return $this;

    }



    /**

     * Get prix_equipement_complet

     *

     * @return string

     */

    public function getPrixEquipementComplet()

    {

        return $this->prix_equipement_complet;

    }



    /**

     * Set prix_ski_seulement

     *

     * @param string $prix_ski_seulement

     *

     * @return Tarif

     */

    public function setPrixSkiSeulement($prix_ski_seulement)

    {

        $this->prix_ski_seulement = $prix_ski_seulement;



        return $this;

    }



    /**

     * Get prix_ski_seulement

     *

     * @return string

     */

    public function getPrixSkiSeulement()

    {

        return $this->prix_ski_seulement;

    }



    /**

     * Set prix_bottes_seulement

     *

     * @param string $prix_bottes_seulement

     *

     * @return Tarif

     */

    public function setPrixBottesSeulement($prix_bottes_seulement)

    {

        $this->prix_bottes_seulement = $prix_bottes_seulement;



        return $this;

    }



    /**

     * Get prix_bottes_seulement

     *

     * @return string

     */

    public function getPrixBottesSeulement()

    {

        return $this->prix_bottes_seulement;

    }



    /**

     * Set prix_batons_seulement

     *

     * @param string $prix_batons_seulement

     *

     * @return Tarif

     */

    public function setPrixBatonsSeulement($prix_batons_seulement)

    {

        $this->prix_batons_seulement = $prix_batons_seulement;



        return $this;

    }



    /**

     * Get prix_batons_seulement

     *

     * @return string

     */

    public function getPrixBatonsSeulement()

    {

        return $this->prix_batons_seulement;

    }



    public function __toString(){

        return $this->sport->getNom() . " (" . $this->categorie->getNom() . ")";

    }

}

