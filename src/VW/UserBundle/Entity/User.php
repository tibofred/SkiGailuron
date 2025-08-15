<?php



namespace VW\UserBundle\Entity;



use Doctrine\ORM\Mapping as ORM;

use FOS\UserBundle\Model\User as BaseUser;



/**

 * User

 *

 * @ORM\Table(name="vw_user")

 * @ORM\Entity(repositoryClass="VW\UserBundle\Repository\UserRepository")

 */

class User extends BaseUser

{

    /**

     * @var int

     *

     * @ORM\Column(name="id", type="integer")

     * @ORM\Id

     * @ORM\GeneratedValue(strategy="AUTO")

     */

    protected $id;

    

   /**

     * @ORM\ManyToMany(targetEntity="VW\UserBundle\Entity\Group")

     * @ORM\JoinTable(name="fos_user_user_group",

     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},

     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}

     * )

     */

    protected $groups;

    

    /**

   * @ORM\OneToOne(targetEntity="VW\ClientBundle\Entity\Client", cascade={"persist"})

   */

    private $client;





    /**

     * Set client

     *

     * @param \VW\ClientBundle\Entity\Client $client

     *

     * @return User

     */

    public function setClient(\VW\ClientBundle\Entity\Client $client = null)

    {

        $this->client = $client;



        return $this;

    }



    /**

     * Get client

     *

     * @return \VW\ClientBundle\Entity\Client

     */

    public function getClient()

    {

        return $this->client;

    }

}

