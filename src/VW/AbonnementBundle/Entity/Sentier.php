<?php



namespace VW\AbonnementBundle\Entity;



use Doctrine\ORM\Mapping as ORM;



/**

 * Sentier

 *

 * @ORM\Table(name="sentiers")

 * @ORM\Entity(repositoryClass="VW\AbonnementBundle\Repository\SentierRepository")

 */

class Sentier

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

     * @ORM\ManyToOne(targetEntity="VW\AbonnementBundle\Entity\Condition", cascade={"persist"},  fetch="EAGER")

     * @ORM\JoinColumn(nullable=true)

     */



    private $condition;

    

    /**

     * @ORM\ManyToOne(targetEntity="VW\AbonnementBundle\Entity\Sport", cascade={"persist"},  fetch="EAGER")

     * @ORM\JoinColumn(nullable=false)

     */



    private $sport;

    

    /**

     * @var string

     *

     * @ORM\Column(name="nom", type="string")

     */

    private $nom;

    

    /**

     * @var string

     *

     * @ORM\Column(name="longueur", type="decimal", precision=10, scale=1)

     */

    private $longueur;

    

    /**

     * @var \DateTime

     *

     * @ORM\Column(name="dernier_tracage", type="datetime", nullable=true)

     */

    private $dernier_tracage;

    

    /**

     * @var string

     *

     * @ORM\Column(name="description", type="string")

     */

    private $description;

    

    /**

     * @var string

     *

     * @ORM\Column(name="slug", type="string")

     */

    private $slug;

    

    
    /**

     * @var string

     *

     * @ORM\Column(name="status", type="boolean")

     */

    private $statut; //0 == fermé, 1 == ouverte

    
    /**

     * @var string

     *

     * @ORM\Column(name="difficulte", type="integer")

     */

    private $difficulte; //0 == Débutant, 1 == Intermédiaire, 2 == Expert



    /**

     * Set condition

     *

     * @param \VW\AbonnementBundle\Entity\Condition $condition

     *

     * @return Sentier

     */

    public function setCondition(\VW\AbonnementBundle\Entity\Condition $condition)

    {

        $this->condition = $condition;



        return $this;

    }



    /**

     * Get condition

     *

     * @return \VW\AbonnementBundle\Entity\Condition

     */

    public function getCondition()

    {

        return $this->condition;

    }



    /**

     * Set sport

     *

     * @param \VW\AbonnementBundle\Entity\Sport $sport

     *

     * @return Sentier

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

     * Set nom

     *

     * @param string $nom

     *

     * @return Sentier

     */

    public function setNom($nom)

    {

        $this->nom = $nom;



        return $this;

    }



    /**

     * Get nom

     *

     * @return string

     */

    public function getNom()

    {

        return $this->nom;

    }

    

    /**

     * Set longueur

     *

     * @param string $longueur

     *

     * @return Sentier

     */

    public function setLongueur($longueur)

    {

        $this->longueur = $longueur;



        return $this;

    }



    /**

     * Get longueur

     *

     * @return string

     */

    public function getLongueur()

    {

        return $this->longueur;

    }

    

    /**

     * Set dernier_tracage

     *

     * @param string $dernier_tracage

     *

     * @return Sentier

     */

    public function setDernierTracage($dernier_tracage)

    {

        $this->dernier_tracage = $dernier_tracage;



        return $this;

    }



    /**

     * Get dernier_tracage

     *

     * @return string

     */

    public function getDernierTracage()

    {

        return $this->dernier_tracage;

    }

    

    /**

     * Set description

     *

     * @param string $description

     *

     * @return Sentier

     */

    public function setDescription($description)

    {

        $this->description = $description;



        return $this;

    }



    /**

     * Get description

     *

     * @return string

     */

    public function getDescription()

    {

        return $this->description;

    }

    

    /**

     * Set slug

     *

     * @param string $slug

     *

     * @return Sentier

     */

    public function setSlug($slug)

    {

        $this->slug = $slug;



        return $this;

    }



    /**

     * Get slug

     *

     * @return string

     */

    public function getSlug()

    {

        return $this->slug;

    }

    

    /**

     * Set statut

     *

     * @param string $statut

     *

     * @return Sentier

     */

    public function setStatut($statut)

    {

        $this->statut = $statut;



        return $this;

    }



    /**

     * Get statut

     *

     * @return string

     */

    public function getStatut()

    {

        return $this->statut;

    }

    

    /**

     * Set difficulte

     *

     * @param string $difficulte

     *

     * @return Sentier

     */

    public function setDifficulte($difficulte)

    {

        $this->difficulte = $difficulte;



        return $this;

    }



    /**

     * Get difficulte

     *

     * @return string

     */

    public function getDifficulte()

    {

        return $this->difficulte;

    }



    public function __toString(){

        return $this->sport->getNom() . " (" . $this->categorie->getNom() . ")";

    }


    /**
     * Set dateNeige
     *
     * @param \DateTime $dateNeige
     *
     * @return Sentier
     */
    public function setDateNeige($dateNeige)
    {
        $this->date_neige = $dateNeige;

        return $this;
    }

    /**
     * Get dateNeige
     *
     * @return \DateTime
     */
    public function getDateNeige()
    {
        return $this->date_neige;
    }

    /**
     * Set qteNeige
     *
     * @param integer $qteNeige
     *
     * @return Sentier
     */
    public function setQteNeige($qteNeige)
    {
        $this->qte_neige = $qteNeige;

        return $this;
    }

    /**
     * Get qteNeige
     *
     * @return integer
     */
    public function getQteNeige()
    {
        return $this->qte_neige;
    }
}
