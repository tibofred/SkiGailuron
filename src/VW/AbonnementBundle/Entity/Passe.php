<?php



namespace VW\AbonnementBundle\Entity;



use Doctrine\ORM\Mapping as ORM;



/**

 * Passe

 *

 * @ORM\Table(name="passe")

 * @ORM\Entity(repositoryClass="VW\AbonnementBundle\Repository\PasseRepository")

 */

class Passe

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

     * @ORM\ManyToOne(targetEntity="VW\AbonnementBundle\Entity\TypeAbonnement", cascade={"persist"},  fetch="EAGER")

     * @ORM\JoinColumn(nullable=false)

     */



    private $type;

    

    

    

    

    /**

     * @var string

     *

     * @ORM\Column(name="nom", type="string", length=255)

     */

    private $nom;



    /**

     * @var string

     *

     * @ORM\Column(name="prenom", type="string", length=255)

     */

    private $prenom;



    /**

     * @var string

     *

     * @ORM\Column(name="date_anniversaire", type="date")

     */

    private $dateAnniversaire;

    

    /**

     * @ORM\OneToOne(targetEntity="VW\AbonnementBundle\Entity\Image", cascade={"persist"}, fetch="EAGER")

     */

    private $image;



    /**

     * @var string

     *

     * @ORM\Column(name="nom_conjoint", type="string", length=255, nullable=true)

     */

    private $nomConjoint;



    /**

     * @var string

     *
     * @ORM\Column(name="prenom_conjoint", type="string", length=255, nullable=true)

     */

    private $prenomConjoint;



    /**

     * @var \DateTime

     *

     * @ORM\Column(name="date_anniversaire_conjoint", type="date", nullable=true)

     */

    private $dateAnniversaireConjoint;

    

    

     /**

     * @ORM\OneToOne(targetEntity="VW\AbonnementBundle\Entity\Image", cascade={"persist"}, fetch="EAGER")

     */

    private $imageConjoint;





    /**

   * @ORM\ManyToOne(targetEntity="VW\AbonnementBundle\Entity\Abonnement", inversedBy="passe")

   * @ORM\JoinColumn(name="abonnement_id", referencedColumnName="id")

   */

  private $abonnement;



    /**

     * Get id

     *

     * @return integer

     */

    public function getId()

    {

        return $this->id;

    }



    /**

     * Set nom

     *

     * @param string $nom

     *

     * @return Passe

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

     * Set prenom

     *

     * @param string $prenom

     *

     * @return Passe

     */

    public function setPrenom($prenom)

    {

        $this->prenom = $prenom;



        return $this;

    }



    /**

     * Get prenom

     *

     * @return string

     */

    public function getPrenom()

    {

        return $this->prenom;

    }



    /**

     * Set dateAnniversaire

     *

     * @param \DateTime $dateAnniversaire

     *

     * @return Passe

     */

    public function setDateAnniversaire($dateAnniversaire)

    {

        $this->dateAnniversaire = $dateAnniversaire;



        return $this;

    }



    /**

     * Get dateAnniversaire

     *

     * @return \DateTime

     */

    public function getDateAnniversaire()

    {

        return $this->dateAnniversaire;

    }



    /**

     * Set nomConjoint

     *

     * @param string $nomConjoint

     *

     * @return Passe

     */

    public function setNomConjoint($nomConjoint)

    {

        $this->nomConjoint = $nomConjoint;



        return $this;

    }



    /**

     * Get nomConjoint

     *

     * @return string

     */

    public function getNomConjoint()

    {

        return $this->nomConjoint;

    }



    /**

     * Set prenomConjoint

     *

     * @param string $prenomConjoint

     *

     * @return Passe

     */

    public function setPrenomConjoint($prenomConjoint)

    {

        $this->prenomConjoint = $prenomConjoint;



        return $this;

    }



    /**

     * Get prenomConjoint

     *

     * @return string

     */

    public function getPrenomConjoint()

    {

        return $this->prenomConjoint;

    }



    /**

     * Set dateAnniversaireConjoint

     *

     * @param \DateTime $dateAnniversaireConjoint

     *

     * @return Passe

     */

    public function setDateAnniversaireConjoint($dateAnniversaireConjoint)

    {

        $this->dateAnniversaireConjoint = $dateAnniversaireConjoint;



        return $this;

    }



    /**

     * Get dateAnniversaireConjoint

     *

     * @return \DateTime

     */

    public function getDateAnniversaireConjoint()

    {

        return $this->dateAnniversaireConjoint;

    }



    /**

     * Set type

     *

     * @param \VW\AbonnementBundle\Entity\TypeAbonnement $type

     *

     * @return Passe

     */

    public function setType(\VW\AbonnementBundle\Entity\TypeAbonnement $type)

    {

        $this->type = $type;



        return $this;

    }



    /**

     * Get type

     *

     * @return \VW\AbonnementBundle\Entity\TypeAbonnement

     */

    public function getType()

    {

        return $this->type;

    }



    /**

     * Set image

     *

     * @param \VW\AbonnementBundle\Entity\Image $image

     *

     * @return Passe

     */

    public function setImage(\VW\AbonnementBundle\Entity\Image $image = null)

    {

        $this->image = $image;



        return $this;

    }



    /**

     * Get image

     *

     * @return \VW\AbonnementBundle\Entity\Image

     */

    public function getImage()

    {

        return $this->image;

    }



    /**

     * Set imageConjoint

     *

     * @param \VW\AbonnementBundle\Entity\Image $imageConjoint

     *

     * @return Passe

     */

    public function setImageConjoint(\VW\AbonnementBundle\Entity\Image $imageConjoint = null)

    {

        $this->imageConjoint = $imageConjoint;



        return $this;

    }



    /**

     * Get imageConjoint

     *

     * @return \VW\AbonnementBundle\Entity\Image

     */

    public function getImageConjoint()

    {

        return $this->imageConjoint;

    }









   



    /**

     * Set abonnement

     *

     * @param \VW\AbonnementBundle\Entity\Abonnement $abonnement

     *

     * @return Passe

     */

    public function setAbonnement(\VW\AbonnementBundle\Entity\Abonnement $abonnement = null)

    {

        $this->abonnement = $abonnement;



        return $this;

    }



    /**

     * Get abonnement

     *

     * @return \VW\AbonnementBundle\Entity\Abonnement

     */

    public function getAbonnement()

    {

        return $this->abonnement;

    }

}

