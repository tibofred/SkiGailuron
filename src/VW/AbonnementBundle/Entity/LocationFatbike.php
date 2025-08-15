<?php



namespace VW\AbonnementBundle\Entity;



use Doctrine\ORM\Mapping as ORM;



/**

 * LocationFatbike

 *

 * @ORM\Table(name="prix_location_fatbike")

 * @ORM\Entity(repositoryClass="VW\AbonnementBundle\Repository\LocationFatbikeRepository")

 */

class LocationFatbike

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

     * @ORM\ManyToOne(targetEntity="VW\AbonnementBundle\Entity\Duree", cascade={"persist"},  fetch="EAGER")

     * @ORM\JoinColumn(nullable=false)

     */

    private $duree;

    

    /**

     * @ORM\ManyToOne(targetEntity="VW\AbonnementBundle\Entity\Sport", cascade={"persist"},  fetch="EAGER")

     * @ORM\JoinColumn(nullable=false)

     */

    private $sport;

    

    /**

     * @var string

     *

     * @ORM\Column(name="prix", type="decimal", precision=10, scale=2)

     */

    private $prix;



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

     * Set duree

     *

     * @param \VW\AbonnementBundle\Entity\Duree $duree

     *

     * @return LocationFatbike

     */

    public function setDuree(\VW\AbonnementBundle\Entity\Duree $duree)

    {

        $this->duree = $duree;



        return $this;

    }



    /**

     * Get duree

     *

     * @return \VW\AbonnementBundle\Entity\Duree

     */

    public function getDuree()

    {

        return $this->duree;

    }



    /**

     * Set sport

     *

     * @param \VW\AbonnementBundle\Entity\Sport $sport

     *

     * @return LocationFatbike

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

     * Set prix

     *

     * @param string $prix

     *

     * @return LocationFatbike

     */

    public function setPrix($prix)

    {

        $this->prix = $prix;



        return $this;

    }



    /**

     * Get prix

     *

     * @return string

     */

    public function getPrix()

    {

        return $this->prix;

    }



    public function __toString(){

        return $this->sport->getNom() . " (" . $this->categorie->getNom() . ")";

    }

}

