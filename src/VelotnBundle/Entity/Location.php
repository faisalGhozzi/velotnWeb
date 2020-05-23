<?php

namespace VelotnBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Location
 *
 * @ORM\Table(name="location", indexes={@ORM\Index(name="id_produitFK", columns={"id_produit"}), @ORM\Index(name="id_userFk", columns={"id_user"}),@ORM\Index(name="id_PromoFk", columns={"id_promo"})})
 * @ORM\Entity(repositoryClass="VelotnBundle\Repository\LocationRepository")
 */
class Location
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
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
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="VelotnBundle\Entity\Produits")
     * @ORM\JoinColumns({
     *  @ORM\JoinColumn(name="id_produit",referencedColumnName="id")
     * })
     */
    private $idProduit;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="VelotnBundle\Entity\User")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="id_user",referencedColumnName="id")
     *})
     */
    private $idUser;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="VelotnBundle\Entity\Promotion")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="id_promo",referencedColumnName="id")
     *})
     */
    private $idPromo;

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
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * @param \DateTime $dateDebut
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;
    }

    /**
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * @param \DateTime $dateFin
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;
    }

    /**
     * @return float
     */
    public function getPrixtotal()
    {
        return $this->prixtotal;
    }

    /**
     * @param float $prixtotal
     */
    public function setPrixtotal($prixtotal)
    {
        $this->prixtotal = $prixtotal;
    }

    /**
     * @return int
     */
    public function getIdProduit()
    {
        return $this->idProduit;
    }

    /**
     * @param int $idProduit
     */
    public function setIdProduit($idProduit)
    {
        $this->idProduit = $idProduit;
    }

    /**
     * @return int
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param int $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

    /**
     * @return int
     */
    public function getIdPromo()
    {
        return $this->idPromo;
    }

    /**
     * @param int $idPromo
     */
    public function setIdPromo($idPromo)
    {
        $this->idPromo = $idPromo;
    }


}

