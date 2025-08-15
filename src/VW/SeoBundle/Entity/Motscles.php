<?php



namespace VW\SeoBundle\Entity;



use Doctrine\ORM\Mapping as ORM;



/**

 * Motscles

 *

 * @ORM\Table(name="motscles")

 * @ORM\Entity(repositoryClass="VW\SeoBundle\Repository\MotsclesRepository")

 */

class Motscles

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

     * @ORM\Column(name="motcle", type="string", length=255, unique=true)

     */

    private $motcle;



    /**

     * @var int

     *

     * @ORM\Column(name="nbrecherche", type="integer")

     */

    private $nbrecherche;



    /**

     * @var int

     *

     * @ORM\Column(name="difficulte", type="integer")

     */

    private $difficulte;



    /**

     * @var \DateTime

     *

     * @ORM\Column(name="date", type="date")

     */

    private $date;

    

    

    public function __construct()

  {

    $this->date         = new \Datetime();

    

  }





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

     * Set motcle

     *

     * @param string $motcle

     *

     * @return Motscles

     */

    public function setMotcle($motcle)

    {

        $this->motcle = $motcle;



        return $this;

    }



    /**

     * Get motcle

     *

     * @return string

     */

    public function getMotcle()

    {

        return $this->motcle;

    }



    /**

     * Set nbrecherche

     *

     * @param integer $nbrecherche

     *

     * @return Motscles

     */

    public function setNbrecherche($nbrecherche)

    {

        $this->nbrecherche = $nbrecherche;



        return $this;

    }



    /**

     * Get nbrecherche

     *

     * @return int

     */

    public function getNbrecherche()

    {

        return $this->nbrecherche;

    }



    /**

     * Set difficulte

     *

     * @param integer $difficulte

     *

     * @return Motscles

     */

    public function setDifficulte($difficulte)

    {

        $this->difficulte = $difficulte;



        return $this;

    }



    /**

     * Get difficulte

     *

     * @return int

     */

    public function getDifficulte()

    {

        return $this->difficulte;

    }



    /**

     * Set date

     *

     * @param \DateTime $date

     *

     * @return Motscles

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

}



