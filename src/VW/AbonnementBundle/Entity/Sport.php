<?php



namespace VW\AbonnementBundle\Entity;



use Doctrine\ORM\Mapping as ORM;



/**

 * Sport

 *

 * @ORM\Table(name="sport")

 * @ORM\Entity(repositoryClass="VW\AbonnementBundle\Repository\SportRepository")

 */

class Sport

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

     * @ORM\Column(name="nom_en", type="string", length=255, unique=true)

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

     * @return Sport

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

     * @return Sport

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

