<?php



namespace VW\AbonnementBundle\Entity;



use Doctrine\ORM\Mapping as ORM;



/**

 * LocationRaquette

 *

 * @ORM\Table(name="prix_location_raquette")

 * @ORM\Entity(repositoryClass="VW\AbonnementBundle\Repository\LocationRaquetteRepository")

 */

class LocationRaquette

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

     * @ORM\Column(name="prix_raquettes_seulement", type="decimal", precision=10, scale=2)

     */

    private $prix_raquettes_seulement;



    /**

     * @var string

     *

     * @ORM\Column(name="prix_raquettes_clair_de_lune", type="decimal", precision=10, scale=2)

     */

    private $prix_raquettes_clair_de_lune;



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

     * @return LocationRaquette

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

     * @return LocationRaquette

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

     * Set prix_raquettes_seulement

     *

     * @param string $prix_raquettes_seulement

     *

     * @return LocationRaquette

     */

    public function setPrixRaquettesSeulement($prix_raquettes_seulement)

    {

        $this->prix_raquettes_seulement = $prix_raquettes_seulement;



        return $this;

    }



    /**

     * Get prix_raquettes_seulement

     *

     * @return string

     */

    public function getPrixRaquettesSeulement()

    {

        return $this->prix_raquettes_seulement;

    }



    /**

     * Set prix_raquettes_clair_de_lune

     *

     * @param string $prix_raquettes_clair_de_lune

     *

     * @return LocationRaquette

     */

    public function setPrixRaquettesClairDeLune($prix_raquettes_clair_de_lune)

    {

        $this->prix_raquettes_clair_de_lune = $prix_raquettes_clair_de_lune;



        return $this;

    }



    /**

     * Get prix_raquettes_clair_de_lune

     *

     * @return string

     */

    public function getPrixRaquettesClairDeLune()

    {

        return $this->prix_raquettes_clair_de_lune;

    }



    /**

     * Set prix_batons_seulement

     *

     * @param string $prix_batons_seulement

     *

     * @return LocationRaquette

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

