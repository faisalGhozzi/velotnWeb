<?php

namespace Velotn\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GroupsMembers
 *
 * @ORM\Table(name="groups_members", indexes={@ORM\Index(name="IDX_5C1D0E4A20641732", columns={"Idauthor"}), @ORM\Index(name="IDX_5C1D0E4AF373DCF", columns={"groups_id"})})
 * @ORM\Entity
 */
class GroupsMembers
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
     * @var integer
     *
     * @ORM\Column(name="groups_id", type="integer", nullable=true)
     */
    private $groupsId;

    /**
     * @var boolean
     *
     * @ORM\Column(name="confirmation", type="boolean", nullable=false)
     */
    private $confirmation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateInscri", type="datetime", nullable=true)
     */
    private $dateinscri;

    /**
     * @var integer
     *
     * @ORM\Column(name="Idauthor", type="integer", nullable=true)
     */
    private $idauthor;

    /**
     * @var string
     *
     * @ORM\Column(name="nomGroup", type="string", length=255, nullable=true)
     */
    private $nomgroup;


}

