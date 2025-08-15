<?php

namespace PaymentBundle\Entity;



use Doctrine\ORM\Mapping as ORM;

use Payum\Core\Model\Payment as BasePayment;



/**

 * @ORM\Table

 * @ORM\Entity

 */

class Payment extends BasePayment

{

    /**

     * @ORM\Column(name="id", type="integer")

     * @ORM\Id

     * @ORM\GeneratedValue(strategy="IDENTITY")

     *

     * @var integer $id

     */

    protected $id;



    /**

     * @ORM\ManyToOne(targetEntity="VW\AbonnementBundle\Entity\Abonnement", inversedBy="transactions")

     * @ORM\JoinColumn(nullable=true)

     */

    protected $abonnement;



    /**

     * Get abonnement

     *

     * @return \VW\AbonnementBundle\Entity\Abonnement

     */

    public function getAbonnement()

    {

        return $this->abonnement;

    }



    /**

     * Set abonnement

     *

     * @param \VW\AbonnementBundle\Entity\Abonnement $abonnement

     *

     * @return Payment

     */

    public function setAbonnement($abonnement)

    {

        $this->abonnement = $abonnement;



        return $this;

    }

}

