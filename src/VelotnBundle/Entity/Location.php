<?php

namespace VelotnBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Location
 *
 * @ORM\Table(name="location", indexes={@ORM\Index(name="id_produitFK", columns={"id_produit"}), @ORM\Index(name="id_userFk", columns={"id_user"}),@ORM\Index(name="id_PromoFk", columns={"id_promo"})})
 * @ORM\Entity
 */
class Location
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_debut", type="date", nullable=false)
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin", type="date", nullable=false)
     */
    private $dateFin;

    /**
     * @var float
     *
     * @ORM\Column(name="prixtotal", type="float", precision=10, scale=0, nullable=false)
     */
    private $prixtotal;

    /**
     * @var \Produits
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Produits")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_produit", referencedColumnName="id")
     * })
     */
    private $idProduit;

    /**
     * @var \FosUser
     *
     * @ORM\ManyToOne(targetEntity="VelotnBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     * })
     */
    private $idUser;

    /**
     * @var \Promotion
     * @ORM\OneToOne(targetEntity="VelotnBundle\Entity\Promotion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_promo",referencedColumnName="id")
     * })
     */
    private $idPromo;


}

