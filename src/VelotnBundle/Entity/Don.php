<?php

namespace VelotnBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Don
 *
 * @ORM\Table(name="don")
 * @ORM\Entity
 */
class Don
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="somme", type="float", precision=10, scale=0, nullable=false)
     */
    private $somme;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="date_don", type="date", nullable=false)
     */
    private $dateDon;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return float
     */
    public function getSomme()
    {
        return $this->somme;
    }

    /**
     * @param float $somme
     */
    public function setSomme($somme)
    {
        $this->somme = $somme;
    }

    /**
     * @return DateTime
     */
    public function getDateDon()
    {
        return $this->dateDon;
    }

    /**
     * @param DateTime $dateDon
     */
    public function setDateDon($dateDon)
    {
        $this->dateDon = $dateDon;
    }


}

