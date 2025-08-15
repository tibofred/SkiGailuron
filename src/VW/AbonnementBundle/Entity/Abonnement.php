<?php



namespace VW\AbonnementBundle\Entity;



use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;



/**

 * Abonnement

 *

 * @ORM\Table(name="abonnement")

 * @ORM\Entity(repositoryClass="VW\AbonnementBundle\Repository\AbonnementRepository")

 */

class Abonnement

{

    /**

     * @var int

     *

     * @ORM\Column(name="id", type="integer")

     * @ORM\Id

     * @ORM\GeneratedValue(strategy="AUTO")

     */

    private $id;



    //Année de l'abonnement (2017, 2018...)

    //$private annee;

    

   /**

   * @ORM\ManyToOne(targetEntity="VW\ClientBundle\Entity\Client", cascade={"persist"}, fetch="EAGER")

   * @ORM\JoinColumn(nullable=false)

   */

    private $client;

    

    /**

     * @ORM\OneToMany(targetEntity="Passe", mappedBy="abonnement", cascade={"persist"}, fetch="EAGER")

     */

    private $passe;



    /**

     * @ORM\OneToMany(targetEntity="PaymentBundle\Entity\Payment", mappedBy="abonnement")

     * @ORM\OrderBy({"id" = "DESC"})

     */

    private $transactions;



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

     * Set client

     *

     * @param \VW\ClientBundle\Entity\Client $client

     *

     * @return Abonnement

     */

    public function setClient(\VW\ClientBundle\Entity\Client $client)

    {

        $this->client = $client;



        return $this;

    }



    /**

     * Get client

     *

     * @return \VW\ClientBundle\Entity\Client

     */

    public function getClient()

    {

        return $this->client;

    }

    

    /**

     * Constructor

     */

    public function __construct()

    {

        $this->passe = new \Doctrine\Common\Collections\ArrayCollection();

        $this->transactions = new \Doctrine\Common\Collections\ArrayCollection();

    }



    /**

     * Add passe

     *

     * @param \VW\AbonnementBundle\Entity\Passe $passe

     *

     * @return Abonnement

     */

    public function addPasse(\VW\AbonnementBundle\Entity\Passe $passe)

    {

        $this->passe[] = $passe;



        return $this;

    }



    /**

     * Remove passe

     *

     * @param \VW\AbonnementBundle\Entity\Passe $passe

     */

    public function removePasse(\VW\AbonnementBundle\Entity\Passe $passe)

    {

        $this->passe->removeElement($passe);

    }



    /**

     * Get passe

     *

     * @return \Doctrine\Common\Collections\Collection

     */

    public function getPasse()

    {

        return $this->passe;

    }



    /**

     * Get transactions

     *

     * @return \Doctrine\Common\Collections\Collection

     */

    public function getTransactions()

    {

        return $this->transactions;

    }



    /**

     * Get transactions

     *

     * @return \Doctrine\Common\Collections\Collection

     */

    public function setTransactions($transactions)

    {

        $this->transactions = $transactions;

    }

}

