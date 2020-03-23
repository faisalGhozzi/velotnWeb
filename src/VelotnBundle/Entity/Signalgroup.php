<?php

namespace VelotnBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Signalgroup
 *
 * @ORM\Table(name="signalgroup", indexes={@ORM\Index(name="IDX_25C3CFE8F9C28DE1", columns={"IdUser"}), @ORM\Index(name="IDX_25C3CFE8B5B93E44", columns={"IdGroup"})})
 * @ORM\Entity
 */
class Signalgroup
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
     * @ORM\Column(name="cause", type="string", length=255, nullable=false)
     */
    private $cause;

    /**
     * @var integer
     *
     * @ORM\Column(name="IdUser", type="integer", nullable=true)
     */
    private $iduser;

    /**
     * @var integer
     *
     * @ORM\Column(name="IdGroup", type="integer", nullable=true)
     */
    private $idgroup;

    /**
     * @var boolean
     *
     * @ORM\Column(name="visible", type="boolean", nullable=true)
     */
    private $visible;

    /**
     * @var boolean
     *
     * @ORM\Column(name="valider", type="boolean", nullable=true)
     */
    private $valider;

    /**
     * @var string
     *
     * @ORM\Column(name="nomGroup", type="string", length=255, nullable=true)
     */
    private $nomgroup;


}

