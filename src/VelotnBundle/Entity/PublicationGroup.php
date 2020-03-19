<?php

namespace Velotn\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PublicationGroup
 *
 * @ORM\Table(name="publication_group", indexes={@ORM\Index(name="IDX_49DF2D4DF9C28DE1", columns={"IdUser"}), @ORM\Index(name="IDX_49DF2D4D7805AC12", columns={"groupid"})})
 * @ORM\Entity
 */
class PublicationGroup
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
     * @ORM\Column(name="groupid", type="integer", nullable=true)
     */
    private $groupid;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text", nullable=false)
     */
    private $contenu;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datePublication", type="datetime", nullable=false)
     */
    private $datepublication;

    /**
     * @var integer
     *
     * @ORM\Column(name="IdUser", type="integer", nullable=true)
     */
    private $iduser;


}

