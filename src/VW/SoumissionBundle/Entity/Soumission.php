<?php



namespace VW\SoumissionBundle\Entity;



use Doctrine\ORM\Mapping as ORM;



/**

 * Soumission

 *

 * @ORM\Table(name="soumission")

 * @ORM\Entity(repositoryClass="VW\SoumissionBundle\Repository\SoumissionRepository")

 */

class Soumission

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

     * @var string

     *

     * @ORM\Column(name="langue", type="string", length=255)

     */

    private $langue;

    

    

   /**

   * @var \DateTime

   *

   * @ORM\Column(name="date", type="datetime")

   */

  private $date;

    

     /**

     * @var int

     *

     * @ORM\Column(name="nbPages", type="integer")

     */

    private $nbPages;

    

    /**

     * @var string

     *

     * @ORM\Column(name="urlDemo", type="string", length=255)

     */

    private $urlDemo;

    

    /**

     * @var string

     *

     * @ORM\Column(name="tempsFonction", type="string", length=255)

     */

    private $tempsFonction;

    

    /**

     * @var string

     *

     * @ORM\Column(name="champActivite", type="text")

     */

    private $champActivite;

    



    

    /**

     * @var string

     *

     * @ORM\Column(name="pourquoiSite", type="text")

     */

    private $pourquoiSite;

    

    

    /**

     * @var string

     *

     * @ORM\Column(name="considerezSite", type="string", length=255)

     */

    private $considerezSite;

    

    /**

     * @var string

     *

     * @ORM\Column(name="tempsSite", type="string", length=255)

     */

    private $tempsSite;

    

    

    /**

     * @var string

     *

     * @ORM\Column(name="finSite", type="string", length=255)

     */

    private $finSite;

    

    /**

     * @var string

     *

     * @ORM\Column(name="importantSite", type="string", length=255)

     */

    private $importantSite;

    

    

    /**

     * @var string

     *

     * @ORM\Column(name="competiteurs", type="string", length=255)

     */

    private $competiteurs;

    

    

    /**

     * @var string

     *

     * @ORM\Column(name="outilsSite", type="text")

     */

    private $outilsSite;

    

    /**

     * @var string

     *

     * @ORM\Column(name="message", type="text")

     */

    private $message;

    

    

    

    

    

    /**

    * @ORM\Column(name="ecommerce", type="boolean")

    */



    private $ecommerce = false;





    /**

     * Get id

     *

     * @return int

     */

    public function getId()

    {

        return $this->id;

    }

    

    public function __construct()

  {

    $this->date         = new \Datetime();

  }





    /**

     * Set langue

     *

     * @param string $langue

     *

     * @return Soumission

     */

    public function setLangue($langue)

    {

        $this->langue = $langue;



        return $this;

    }



    /**

     * Get langue

     *

     * @return string

     */

    public function getLangue()

    {

        return $this->langue;

    }



    /**

     * Set date

     *

     * @param \DateTime $date

     *

     * @return Soumission

     */

    public function setDate($date)

    {

        $this->date = $date;



        return $this;

    }



    /**

     * Get date

     *

     * @return \DateTime

     */

    public function getDate()

    {

        return $this->date;

    }



    /**

     * Set nbPages

     *

     * @param integer $nbPages

     *

     * @return Soumission

     */

    public function setNbPages($nbPages)

    {

        $this->nbPages = $nbPages;



        return $this;

    }



    /**

     * Get nbPages

     *

     * @return integer

     */

    public function getNbPages()

    {

        return $this->nbPages;

    }



    /**

     * Set urlDemo

     *

     * @param string $urlDemo

     *

     * @return Soumission

     */

    public function setUrlDemo($urlDemo)

    {

        $this->urlDemo = $urlDemo;



        return $this;

    }



    /**

     * Get urlDemo

     *
     * @return string

     */

    public function getUrlDemo()

    {

        return $this->urlDemo;

    }



    /**

     * Set message

     *

     * @param string $message

     *

     * @return Soumission

     */

    public function setMessage($message)

    {

        $this->message = $message;



        return $this;

    }



    /**

     * Get message

     *

     * @return string

     */

    public function getMessage()

    {

        return $this->message;

    }



    /**

     * Set ecommerce

     *

     * @param boolean $ecommerce

     *

     * @return Soumission

     */

    public function setEcommerce($ecommerce)

    {

        $this->ecommerce = $ecommerce;



        return $this;

    }



    /**

     * Get ecommerce

     *

     * @return boolean

     */

    public function getEcommerce()

    {

        return $this->ecommerce;

    }



    /**

     * Set client

     *

     * @param \VW\ClientBundle\Entity\Client $client

     *

     * @return Soumission

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

     * Set tempsFonction

     *

     * @param string $tempsFonction

     *

     * @return Soumission

     */

    public function setTempsFonction($tempsFonction)

    {

        $this->tempsFonction = $tempsFonction;



        return $this;

    }



    /**

     * Get tempsFonction

     *

     * @return string

     */

    public function getTempsFonction()

    {

        return $this->tempsFonction;

    }



    /**

     * Set champActivite

     *

     * @param string $champActivite

     *

     * @return Soumission

     */

    public function setChampActivite($champActivite)

    {

        $this->champActivite = $champActivite;



        return $this;

    }



    /**

     * Get champActivite

     *

     * @return string

     */

    public function getChampActivite()

    {

        return $this->champActivite;

    }



    /**

     * Set pourquoiSite

     *

     * @param string $pourquoiSite

     *

     * @return Soumission

     */

    public function setPourquoiSite($pourquoiSite)

    {

        $this->pourquoiSite = $pourquoiSite;



        return $this;

    }



    /**

     * Get pourquoiSite

     *

     * @return string

     */

    public function getPourquoiSite()

    {

        return $this->pourquoiSite;

    }



    /**

     * Set considerezSite

     *

     * @param string $considerezSite

     *

     * @return Soumission

     */

    public function setConsiderezSite($considerezSite)

    {

        $this->considerezSite = $considerezSite;



        return $this;

    }



    /**

     * Get considerezSite

     *

     * @return string

     */

    public function getConsiderezSite()

    {

        return $this->considerezSite;

    }



    /**

     * Set tempsSite

     *

     * @param string $tempsSite

     *

     * @return Soumission

     */

    public function setTempsSite($tempsSite)

    {

        $this->tempsSite = $tempsSite;



        return $this;

    }



    /**

     * Get tempsSite

     *

     * @return string

     */

    public function getTempsSite()

    {

        return $this->tempsSite;

    }



    /**

     * Set finSite

     *

     * @param string $finSite

     *

     * @return Soumission

     */

    public function setFinSite($finSite)

    {

        $this->finSite = $finSite;



        return $this;

    }



    /**

     * Get finSite

     *

     * @return string

     */

    public function getFinSite()

    {

        return $this->finSite;

    }



    /**

     * Set importantSite

     *

     * @param string $importantSite

     *

     * @return Soumission

     */

    public function setImportantSite($importantSite)

    {

        $this->importantSite = $importantSite;



        return $this;

    }


    /**

     * Get importantSite

     *

     * @return string

     */

    public function getImportantSite()

    {

        return $this->importantSite;

    }



    /**

     * Set competiteurs

     *

     * @param string $competiteurs

     *

     * @return Soumission

     */

    public function setCompetiteurs($competiteurs)

    {

        $this->competiteurs = $competiteurs;



        return $this;

    }



    /**

     * Get competiteurs

     *

     * @return string

     */

    public function getCompetiteurs()

    {

        return $this->competiteurs;

    }



    /**

     * Set outilsSite

     *

     * @param string $outilsSite

     *

     * @return Soumission

     */

    public function setOutilsSite($outilsSite)

    {

        $this->outilsSite = $outilsSite;



        return $this;

    }



    /**

     * Get outilsSite

     *

     * @return string

     */

    public function getOutilsSite()

    {

        return $this->outilsSite;

    }

}

