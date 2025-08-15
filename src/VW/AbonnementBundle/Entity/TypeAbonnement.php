<?php



namespace VW\AbonnementBundle\Entity;



use Doctrine\ORM\Mapping as ORM;



/**

 * TypeAbonnement

 *

 * @ORM\Table(name="type_abonnement")

 * @ORM\Entity(repositoryClass="VW\AbonnementBundle\Repository\TypeAbonnementRepository")

 */

class TypeAbonnement

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

     * @ORM\ManyToOne(targetEntity="VW\AbonnementBundle\Entity\categorie")

     * @ORM\JoinColumn(nullable=false)

     */





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

     * @ORM\Column(name="prix", type="decimal", precision=10, scale=2)

     */

    private $prix;




    /**

     * @var string

     *

     * @ORM\Column(name="prevente", type="decimal", precision=10, scale=2)

     */

    private $prevente;





    /**

     * Set categorie

     *

     * @param \VW\AbonnementBundle\Entity\Categorie $categorie

     *

     * @return TypeAbonnement

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

     * @return TypeAbonnement

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

     * @return TypeAbonnement

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
    
    /**

     * Set prevente

     *

     * @param string $prevente

     *

     * @return TypeAbonnement

     */

    public function setPrevente($prevente)

    {

        $this->prevente = $prevente;



        return $this;

    }



    /**

     * Get prevente

     *

     * @return string

     */

    public function getPrevente()

    {

        return $this->prevente;

    }

    public function getNom(){
        return $this->sport->getNom() . " (" . $this->categorie->getNom() . ")";
    }

    public function getNomEn(){
        return $this->sport->getNomEn() . " (" . $this->categorie->getNomEn() . ")";
    }

    public function __toString()

    {

        return $this->sport->getNom() . " (" . $this->categorie->getNom() . ")";

    }

}

