<?php



namespace VW\BaseBundle\Entity;



use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Constraints as Assert;



/**

 * Pages

 *

 * @ORM\Table(name="pages")

 * @ORM\Entity(repositoryClass="VW\BaseBundle\Repository\PagesRepository")

 */

class Pages

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

     * @ORM\Column(name="contenu", type="text")

     */

    private $contenu;

    

    /**

     * @var string

     *

     * @ORM\Column(name="titre", type="string", length=255)

     * @Assert\Length(min=3, minMessage="Le titre doit faire au moins {{ limit }} caractères.")

     */

    private $titre;

    

    /**

     * @var string

     *

     * @ORM\Column(name="url", type="string", length=255, unique=true)

     */

    private $url;

    

    /**

    * @ORM\OneToOne(targetEntity="VW\BaseBundle\Entity\Image", cascade={"persist"})

    */

    private $image;

    

    /**



   * @ORM\OneToOne(targetEntity="VW\SeoBundle\Entity\Seo", cascade={"persist"})



   */

    private $seo;

    

    

    /**

   * @ORM\ManyToMany(targetEntity="VW\SeoBundle\Entity\Motscles", cascade={"persist"})

   */

    private $motscles;

    

    /**



   * @ORM\OneToOne(targetEntity="VW\SeoBundle\Entity\OpenGraph", cascade={"persist"})



   */

    private $opengraph;

    

    /**



   * @ORM\OneToOne(targetEntity="VW\SeoBundle\Entity\ImageFaceBook", cascade={"persist"})



   */

    private $imagefacebook;

    

   



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

     * Set contenu

     *

     * @param string $contenu

     *

     * @return Pages

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

    

    /**

     * Set titre

     *

     * @param string $titre

     *

     * @return Pages

     */

    public function setTitre($titre)

    {

        $this->titre = $titre;



        return $this;

    }



    /**

     * Get titre

     *

     * @return string

     */

    public function getTitre()

    {

        return $this->titre;

    }

    

    /**

     * Set url

     *

     * @param string $url

     *

     * @return Pages

     */

    public function setUrl($url)

    {

        $this->url = $url;



        return $this;

    }



    /**

     * Get url

     *

     * @return string

     */

    public function getUrl()

    {

        return $this->url;

    }

    



    /**

     * Set image

     *

     * @param \VW\BaseBundle\Entity\Image $image

     *

     * @return Pages

     */

    public function setImage(\VW\BaseBundle\Entity\Image $image = null)

    {

        $this->image = $image;



        return $this;

    }



    /**

     * Get image

     *

     * @return \VW\BaseBundle\Entity\Image

     */

    public function getImage()

    {

        return $this->image;

    }



    /**

     * Set seo

     *

     * @param \VW\SeoBundle\Entity\Seo $seo

     *

     * @return Pages

     */

    public function setSeo(\VW\SeoBundle\Entity\Seo $seo = null)

    {

        $this->seo = $seo;



        return $this;

    }



    /**

     * Get seo

     *

     * @return \VW\SeoBundle\Entity\Seo

     */

    public function getSeo()

    {

        return $this->seo;

    }



    /**

     * Set opengraph

     *

     * @param \VW\SeoBundle\Entity\OpenGraph $opengraph

     *

     * @return Pages

     */

    public function setOpengraph(\VW\SeoBundle\Entity\OpenGraph $opengraph = null)

    {

        $this->opengraph = $opengraph;



        return $this;

    }



    /**

     * Get opengraph

     *

     * @return \VW\SeoBundle\Entity\OpenGraph

     */

    public function getOpengraph()

    {

        return $this->opengraph;

    }



    /**

     * Set imagefacebook

     *

     * @param \VW\SeoBundle\Entity\ImageFaceBook $imagefacebook

     *

     * @return Pages

     */

    public function setImagefacebook(\VW\SeoBundle\Entity\ImageFaceBook $imagefacebook = null)

    {

        $this->imagefacebook = $imagefacebook;



        return $this;

    }



    /**

     * Get imagefacebook

     *

     * @return \VW\SeoBundle\Entity\ImageFaceBook

     */

    public function getImagefacebook()

    {

        return $this->imagefacebook;

    }

    

    

    /**

     * Constructor

     */

    public function __construct()

    {

        $this->motscles = new \Doctrine\Common\Collections\ArrayCollection();

    }



    /**

     * Add motscle

     *

     * @param \VW\SeoBundle\Entity\Motscles $motscle

     *

     * @return Pages

     */

    public function addMotscle(\VW\SeoBundle\Entity\Motscles $motscle)

    {

        $this->motscles[] = $motscle;



        return $this;

    }



    /**

     * Remove motscle

     *

     * @param \VW\SeoBundle\Entity\Motscles $motscle

     */

    public function removeMotscle(\VW\SeoBundle\Entity\Motscles $motscle)

    {

        $this->motscles->removeElement($motscle);

    }



    /**

     * Get motscles

     *

     * @return \Doctrine\Common\Collections\Collection

     */

    public function getMotscles()

    {

        return $this->motscles;

    }

}

