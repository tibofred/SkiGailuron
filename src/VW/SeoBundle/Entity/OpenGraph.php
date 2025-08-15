<?php



namespace VW\SeoBundle\Entity;



use Doctrine\ORM\Mapping as ORM;



/**

 * OpenGraph

 *

 * @ORM\Table(name="open_graph")

 * @ORM\Entity(repositoryClass="VW\SeoBundle\Repository\OpenGraphRepository")

 */

class OpenGraph

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

     * @ORM\Column(name="ogtitle", type="string", length=255, nullable=true)

     */

    private $ogtitle;



    /**

     * @var string

     *

     * @ORM\Column(name="ogdescription", type="string", length=255, nullable=true)

     */

    private $ogdescription;

    



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

     * Set ogtitle

     *

     * @param string $ogtitle

     *

     * @return OpenGraph

     */

    public function setOgtitle($ogtitle)

    {

        $this->ogtitle = $ogtitle;



        return $this;

    }



    /**

     * Get ogtitle

     *

     * @return string

     */

    public function getOgtitle()

    {

        return $this->ogtitle;

    }



    /**

     * Set ogdescription

     *

     * @param string $ogdescription

     *

     * @return OpenGraph

     */

    public function setOgdescription($ogdescription)

    {

        $this->ogdescription = $ogdescription;



        return $this;

    }



    /**

     * Get ogdescription

     *

     * @return string

     */

    public function getOgdescription()

    {

        return $this->ogdescription;

    }



}

