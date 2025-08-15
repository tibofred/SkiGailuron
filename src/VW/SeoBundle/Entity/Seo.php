<?php



namespace VW\SeoBundle\Entity;



use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Constraints as Assert;



/**

 * Seo

 *

 * @ORM\Table(name="seo")

 * @ORM\Entity(repositoryClass="VW\SeoBundle\Repository\SeoRepository")

 */

class Seo

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

     * @ORM\Column(name="h1", type="string", length=255)

     */

    private $h1;



    /**

     * @var string

     *

     * @ORM\Column(name="meta_title", type="string", length=255)

     * @Assert\Length(min=10)

     */

    private $metaTitle;



    /**

     * @var string

     *

     * @ORM\Column(name="meta_description", type="string", length=255)

     */

    private $metaDescription;







    /**

     * @var string

     *

     * @ORM\Column(name="h2", type="string", length=255, nullable=true)

     */

    private $h2;







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

     * Set h1

     *

     * @param string $h1

     *

     * @return Seo

     */

    public function setH1($h1)
    {

        $this->h1 = $h1;



        return $this;

    }



    /**

     * Get h1

     *

     * @return string

     */

    public function getH1()

    {

        return $this->h1;

    }



    /**

     * Set metaTitle

     *

     * @param string $metaTitle

     *

     * @return Seo

     */

    public function setMetaTitle($metaTitle)

    {

        $this->metaTitle = $metaTitle;



        return $this;

    }



    /**

     * Get metaTitle

     *

     * @return string

     */

    public function getMetaTitle()

    {

        return $this->metaTitle;

    }



    /**

     * Set metaDescription

     *

     * @param string $metaDescription

     *

     * @return Seo

     */

    public function setMetaDescription($metaDescription)

    {

        $this->metaDescription = $metaDescription;



        return $this;

    }



    /**

     * Get metaDescription

     *

     * @return string

     */

    public function getMetaDescription()

    {

        return $this->metaDescription;

    }





    /**

     * Set h2

     *

     * @param string $h2

     *

     * @return Seo

     */

    public function setH2($h2)

    {

        $this->h2 = $h2;



        return $this;

    }



    /**

     * Get h2

     *

     * @return string

     */

    public function getH2()

    {

        return $this->h2;

    }



    

}



