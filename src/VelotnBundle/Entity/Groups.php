<?php

namespace Velotn\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Groups
 *
 * @ORM\Table(name="groups", uniqueConstraints={@ORM\UniqueConstraint(name="nom", columns={"nom"})}, indexes={@ORM\Index(name="IDX_F06D3970F9C28DE1", columns={"IdUser"})})
 * @ORM\Entity
 */
class Groups
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
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbrMembre", type="integer", nullable=false)
     */
    private $nbrmembre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_de_creation", type="date", nullable=false)
     */
    private $dateDeCreation;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=false)
     */
    private $image;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbr_signal", type="integer", nullable=false)
     */
    private $nbrSignal;

    /**
     * @var integer
     *
     * @ORM\Column(name="IdUser", type="integer", nullable=true)
     */
    private $iduser;

    /**
     * @var string
     *
     * @ORM\Column(name="lieux", type="string", length=255, nullable=true)
     */
    private $lieux;


}

