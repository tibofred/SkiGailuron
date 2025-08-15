<?php



namespace VW\ClientBundle\Entity;



use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;

use OC\PlatformBundle\Validator\Antiflood;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\Validator\Context\ExecutionContextInterface;



/**

 * Client

 *

 * @ORM\Table(name="client")

 * @ORM\Entity(repositoryClass="VW\ClientBundle\Repository\ClientRepository")

 */

class Client

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

     * @ORM\Column(name="prenom", type="string", length=255)

     */

    private $prenom;



    /**

     * @var string

     *

     * @Assert\NotNull(

     *     message = "Entrez votre nom de famille SVP",

     * )

     * @ORM\Column(name="nom", type="string", length=255)

     */

    private $nom;

    

    



    



    /**

     * @var string

     *

     * @ORM\Column(name="courriel", type="string", length=255, unique=true)

     * @Assert\Email(

     *     message = "Le courriel '{{ value }}' n'est pas valide.",

     *     checkMX = true

     * )

     */

    private $courriel;



    

    /**

     * @var string

     *

     * @ORM\Column(name="telephone", type="string", length=255)

     */

    private $telephone;



    /**

     * @var string

     *

     * @ORM\Column(name="adresse", type="string", length=255)

     */

    private $adresse;



    /**

     * @var string

     *

     * @ORM\Column(name="codepostal", type="string", length=255)

     */

    private $codepostal;



    /**

     * @var string

     *

     * @ORM\Column(name="ville", type="string", length=255)

     */

    private $ville;



    

     /**

     * @var string

     *

     * @ORM\Column(name="province", type="string", length=255, nullable=true)

     */

    private $province;



    /**

     * @var string

     *

     * @ORM\Column(name="pays", type="string", length=255, nullable=true)

     * @Assert\Country()

     */

    private $pays;

    

    





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

     * Set prenom

     *

     * @param string $prenom

     *

     * @return Client

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

     * Set nom

     *

     * @param string $nom

     *

     * @return Client

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

     * Set courriel

     *

     * @param string $courriel

     *

     * @return Client

     */

    public function setCourriel($courriel)

    {

        $this->courriel = $courriel;



        return $this;

    }



    /**

     * Get courriel

     *

     * @return string

     */

    public function getCourriel()

    {

        return $this->courriel;

    }



    /**

     * Set telephone

     *

     * @param string $telephone

     *

     * @return Client

     */

    public function setTelephone($telephone)

    {

        $this->telephone = $telephone;



        return $this;

    }



    /**

     * Get telephone

     *

     * @return string

     */

    public function getTelephone()

    {

        return $this->telephone;

    }



    /**

     * Set adresse

     *

     * @param string $adresse

     *

     * @return Client

     */

    public function setAdresse($adresse)

    {

        $this->adresse = $adresse;



        return $this;

    }



    /**

     * Get adresse

     *

     * @return string

     */

    public function getAdresse()

    {

        return $this->adresse;

    }



    /**

     * Set codepostal

     *

     * @param string $codepostal

     *

     * @return Client

     */

    public function setCodepostal($codepostal)

    {

        $this->codepostal = $codepostal;



        return $this;

    }



    /**

     * Get codepostal

     *

     * @return string

     */

    public function getCodepostal()

    {

        return $this->codepostal;

    }



    /**

     * Set ville

     *

     * @param string $ville

     *

     * @return Client

     */

    public function setVille($ville)

    {

        $this->ville = $ville;



        return $this;

    }



    /**

     * Get ville

     *

     * @return string

     */

    public function getVille()

    {

        return $this->ville;

    }



    /**

     * Set province

     *

     * @param string $province

     *

     * @return Client

     */

    public function setProvince($province)

    {

        $this->province = $province;



        return $this;

    }



    /**

     * Get province

     *

     * @return string

     */

    public function getProvince()

    {

        return $this->province;

    }



    /**

     * Set pays

     *

     * @param string $pays

     *

     * @return Client

     */

    public function setPays($pays)

    {

        $this->pays = $pays;



        return $this;

    }



    /**

     * Get pays

     *

     * @return string

     */

    public function getPays()

    {

        return $this->pays;

    }

}

