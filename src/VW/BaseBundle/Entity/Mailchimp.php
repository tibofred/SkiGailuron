<?php



namespace VW\BaseBundle\Entity;



use Doctrine\ORM\Mapping as ORM;



/**

 * Mailchimp

 *

 * @ORM\Table(name="mailchimp")

 * @ORM\Entity(repositoryClass="VW\BaseBundle\Repository\MailchimpRepository")

 */

class Mailchimp

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

     * @ORM\Column(name="email", type="string", length=255, unique=true)

     */

    private $email;



    /**

     * @var string

     *

     * @ORM\Column(name="nom", type="string", length=255, nullable=true)

     */

    private $nom;



    /**

     * @var string

     *

     * @ORM\Column(name="prenom", type="string", length=255, nullable=true)

     */

    private $prenom;





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

     * Set email

     *

     * @param string $email

     *

     * @return Mailchimp

     */

    public function setEmail($email)

    {

        $this->email = $email;



        return $this;

    }



    /**

     * Get email

     *

     * @return string

     */

    public function getEmail()

    {

        return $this->email;

    }



    /**

     * Set nom

     *

     * @param string $nom

     *

     * @return Mailchimp

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

     * Set prenom

     *

     * @param string $prenom

     *

     * @return Mailchimp

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

}



