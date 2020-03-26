<?php

namespace VelotnBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Panier
 *
 * @ORM\Table(name="panier", indexes={@ORM\Index(name="fk_produit", columns={"produit_id"}), @ORM\Index(name="fk_user_panier", columns={"user_id"})})
 * @ORM\Entity
 */
class Panier
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
     * @ORM\Column(name="qte", type="integer", nullable=false)
     */
    private $qte;

    /**
     * @var string
     *
     * @ORM\Column(name="prix_unitaire", type="decimal", precision=10, scale=0, nullable=false)
     */
    private $prixUnitaire;

    /**
     * @var string
     *
     * @ORM\Column(name="prix_total", type="decimal", precision=10, scale=0, nullable=false)
     */
    private $prixTotal;

    /**
     * @var integer
     * @ORM\Column(name="produit_id", type="integer",nullable=false)
     */
    private $produit;

    /**
     * @var integer
     * @ORM\Column(name="user_id", type="integer",nullable=false)
     */
    private $user;

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
     * @return int
     */
    public function getQte()
    {
        return $this->qte;
    }

    /**
     * @param int $qte
     */
    public function setQte($qte)
    {
        $this->qte = $qte;
    }

    /**
     * @return string
     */
    public function getPrixUnitaire()
    {
        return $this->prixUnitaire;
    }

    /**
     * @param string $prixUnitaire
     */
    public function setPrixUnitaire($prixUnitaire)
    {
        $this->prixUnitaire = $prixUnitaire;
    }

    /**
     * @return string
     */
    public function getPrixTotal()
    {
        return $this->prixTotal;
    }

    /**
     * @param string $prixTotal
     */
    public function setPrixTotal($prixTotal)
    {
        $this->prixTotal = $prixTotal;
    }

    /**
     * @return integer
     */
    public function getProduit()
    {
        return $this->produit;
    }

    /**
     * @param integer $produit
     */
    public function setProduit($produit)
    {
        $this->produit = $produit;
    }

    /**
     * @return int
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param integer $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }


}

