<?php



namespace VW\ClientBundle\Entity;



use Doctrine\ORM\Mapping as ORM;



/**

 * Ville

 *

 * @ORM\Table(name="ville")

 * @ORM\Entity(repositoryClass="VW\ClientBundle\Repository\VilleRepository")

 */

class Ville

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

     * @ORM\Column(name="nom", type="string", length=255, unique=true)

     */

    private $nom;

    

    /**

     * @var string

     *

     * @ORM\Column(name="region", type="string", length=255)

     */

    private $region;



    /**

     * @var string

     *

     * @ORM\Column(name="slug", type="string", length=255, unique=true)

     */

    private $slug;



    /**

     * @var string

     *

     * @ORM\Column(name="contenu", type="text")

     */

    private $contenu;

    

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

     * Set nom

     *

     * @param string $nom

     *

     * @return Ville

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

     * Set slug

     *

     * @param string $slug

     *

     * @return Ville

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

     * Set region

     *

     * @param string $region

     *

     * @return Ville

     */

    public function setRegion($region)

    {

        $this->region = $region;



        return $this;

    }



    /**

     * Get region

     *

     * @return string

     */

    public function getRegion()

    {

        return $this->region;

    }



    /**

     * Set contenu

     *

     * @param string $contenu

     *

     * @return Ville

     */

    public function setContenu($contenu)

    {

        $this->contenu = $contenu;



        return $this;

    }



    /**

     * Get contenu

     *

     * @return string

     */

    public function getContenu()

    {

        return $this->contenu;

    }

}

