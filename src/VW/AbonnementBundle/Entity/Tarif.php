<?php



namespace VW\AbonnementBundle\Entity;



use Doctrine\ORM\Mapping as ORM;



/**

 * Tarif

 *

 * @ORM\Table(name="tarifs")

 * @ORM\Entity(repositoryClass="VW\AbonnementBundle\Repository\TarifRepository")

 */

class Tarif

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

     * @ORM\Column(name="prix_semaine", type="decimal", precision=10, scale=2)

     */

    private $prix_semaine;



    /**

     * @var string

     *

     * @ORM\Column(name="prix_fin_de_semaine", type="decimal", precision=10, scale=2)

     */

    private $prix_fin_de_semaine;





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

     * Set prix_semaine

     *

     * @param string $prix_semaine

     *

     * @return Tarif

     */

    public function setPrixSemaine($prix_semaine)

    {

        $this->prix_semaine = $prix_semaine;



        return $this;

    }



    /**

     * Get prix_semaine

     *

     * @return string

     */

    public function getPrixSemaine()

    {

        return $this->prix_semaine;

    }



    /**

     * Set prix_fin_de_semaine

     *

     * @param string $prix_fin_de_semaine

     *

     * @return Tarif

     */

    public function setPrixFinDeSemaine($prix_fin_de_semaine)

    {

        $this->prix_fin_de_semaine = $prix_fin_de_semaine;



        return $this;

    }



    /**

     * Get prix_fin_de_semaine

     *

     * @return string

     */

    public function getPrixFinDeSemaine()

    {

        return $this->prix_fin_de_semaine;

    }



    public function __toString(){

        return $this->sport->getNom() . " (" . $this->categorie->getNom() . ")";

    }

}

