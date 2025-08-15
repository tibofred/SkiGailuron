<?php



namespace VW\AbonnementBundle\Entity;



use Doctrine\ORM\Mapping as ORM;



/**

 * Condition

 *

 * @ORM\Table(name="conditions")

 * @ORM\Entity(repositoryClass="VW\AbonnementBundle\Repository\ConditionRepository")

 */

class Condition

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

     * @ORM\Column(name="nomEn", type="string", length=255, unique=true)

     */

    private $nomEn;





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

     * @return Condition

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

     * Set nomEn

     *

     * @param string $nomEn

     *

     * @return Condition

     */

    public function setNomEn($nomEn)

    {

        $this->nomEn = $nomEn;



        return $this;

    }



    /**

     * Get nomEn

     *

     * @return string

     */

    public function getNomEn()

    {

        return $this->nomEn;

    }

}

