<?php



namespace VW\AbonnementBundle\Entity;



use Doctrine\ORM\Mapping as ORM;



/**

 * Centre

 *

 * @ORM\Table(name="centres")

 * @ORM\Entity(repositoryClass="\VW\AbonnementBundle\Repository\CentreRepository")

 */

class Centre

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

     * @var string

     *

     * @ORM\Column(name="status", type="boolean")

     */

    private $statut; //0 == fermé, 1 == ouverte

	/**

     * @var string

     *

     * @ORM\Column(name="status_fatbike", type="boolean")

     */

    private $status_fatbike; //0 == fermé, 1 == ouverte

	/**

     * @var string

     *

     * @ORM\Column(name="status_raquette", type="boolean")

     */

    private $status_raquette; //0 == fermé, 1 == ouverte
    
	/**

     * @var string

     *

     * @ORM\Column(name="capacite", type="boolean")

     */

    private $capacite; //0 == non, 1 == oui

    
    /**

     * @var \DateTime

     *

     * @ORM\Column(name="date_neige", type="datetime", nullable=true)

     */

    private $date_neige;
    
    
    /**

     * @var int

     *

     * @ORM\Column(name="qte_neige", type="integer")


     */

    private $qte_neige;
    


	/**

     * @var string

     *

     * @ORM\Column(name="annee", type="string")

     */

    private $annee; 


	/**

     * Set statut

     *

     * @param string $statut

     *

     * @return Centre

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

     * Set status_fatbike

     *

     * @param string $status_fatbike

     *

     * @return Centre

     */

    public function setStatusFatbike($status_fatbike)

    {

        $this->status_fatbike = $status_fatbike;



        return $this;

    }



    /**

     * Get status_fatbike

     *

     * @return string

     */

    public function getStatusFatbike()

    {

        return $this->status_fatbike;

    }



	/**

     * Set status_raquette

     *

     * @param string $statut

     *

     * @return Centre

     */

    public function setStatusRaquette($status_raquette)

    {

        $this->status_raquette = $status_raquette;



        return $this;

    }



    /**

     * Get status_raquette

     *

     * @return string

     */

    public function getStatusRaquette()

    {

        return $this->status_raquette;

    }

    

	/**
     * Set capacite
     *
     * @param string $capacite
     *
     * @return Centre
     */
    public function setCapacite($capacite)
    {
        $this->capacite = $capacite;
        return $this;
    }
    /**
     * Get capacite
     *
     * @return string
     */

    public function getCapacite()
    {
        return $this->capacite;
    }


    /**
     * Set dateNeige
     *
     * @param \DateTime $dateNeige
     *
     * @return Centre
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
     * @return Centre
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
    
    

	/**
     * Set annee
     *
     * @param string $annee
     *
     * @return Centre
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;
        return $this;
    }
    /**
     * Get annee
     *
     * @return string
     */

    public function getAnnee()
    {
        return $this->annee;
    }

}
