<?php



namespace VW\ContactBundle\Entity;



use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;



/**

 * Contact

 *

 * @ORM\Table(name="contact")

 * @ORM\Entity(repositoryClass="VW\ContactBundle\Repository\ContactRepository")

 */

class Contact

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

     * @ORM\Column(name="name", type="string", length=255)

     */

    private $name;



    /**

     * @var string

     *

     * @ORM\Column(name="email", type="string", length=255)

     * @Assert\Email(

     *      message = "Le courriel entrer : '{{ value }}', n'est pas valide.",

     *      checkMX = true

     * )

     */

    private $email;

    

    /**

     * @var string

     *

     * @ORM\Column(name="phone", type="string", length=50, nullable=true)

     */

    private $phone;



    /**

     * @var string

     *

     * @ORM\Column(name="subject", type="string", length=255)

     */

    private $subject;



    /**

     * @var string

     *

     * @ORM\Column(name="message", type="string", length=255)

     */

    private $message;



    /**

     * @var date

     *

     * @ORM\Column(name="date", type="datetime")

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

     * Set name

     *

     * @param string $name

     *

     * @return Contact

     */

    public function setName($name)

    {

        $this->name = $name;



        return $this;

    }



    /**

     * Get name

     *

     * @return string

     */

    public function getName()

    {

        return $this->name;

    }



    /**

     * Set email

     *

     * @param string $email

     *

     * @return Contact

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

     * Set subject

     *

     * @param string $subject

     *

     * @return Contact

     */

    public function setSubject($subject)

    {

        $this->subject = $subject;



        return $this;

    }



    /**

     * Get subject

     *

     * @return string

     */

    public function getSubject()

    {

        return $this->subject;

    }



    /**

     * Set message

     *

     * @param string $message

     *

     * @return Contact

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

     * Set date

     *

     * @param \DateTime $date

     *

     * @return Contact

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

     * Set phone

     *

     * @param string $phone

     *

     * @return Contact

     */

    public function setPhone($phone)

    {

        $this->phone = $phone;



        return $this;

    }



    /**

     * Get phone

     *

     * @return string

     */

    public function getPhone()

    {

        return $this->phone;

    }

}

