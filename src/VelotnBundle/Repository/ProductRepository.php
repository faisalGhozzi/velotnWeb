<?php
namespace VelotnBundle\Repository;

use Doctrine\ORM\EntityRepository;

class   ProductRepository extends EntityRepository{

    public function findAllProducts()
    {
        return $this->createQueryBuilder("product")
            ->select()
           ->from("VelotnBundle:Produits","u")
            ->from("VelotnBundle:Velos","v")
            ->from("VelotnBundle:Accessoires","a")
            ->from("VelotnBundle:Piecesrechanges","pr")
            ->from("VelotnBundle:ProduitsLocation","pl")
            ->innerJoin("v.id","j1")
            ->innerJoin("a.id","j2")
            ->innerJoin("pr.id","j3")
            ->innerJoin("pl.id","j4")
            ->getQuery()
            ->execute();
    }

    public function findAllVelos()
    {
        return $this->createQueryBuilder("product")
            ->select()
            ->from("VelotnBundle:Velos","velo")
            ->innerJoin("velo.id","v")
            ->getQuery()
            ->execute();

    }

    public function findAllAccessoires()
    {
        return $this->createQueryBuilder("product")
            ->select()
            ->from("VelotnBundle:Accessoires","acc")
            ->innerJoin("acc.id","a")
            ->getQuery()
            ->execute();

    }

    public function findAllPieceRechanges()
    {
        return $this->createQueryBuilder("product")
            ->select()
            ->from("VelotnBundle:Piecesrechanges","piecer")
            ->innerJoin("piecer.id","pr")
            ->getQuery()
            ->execute();

    }

    public function findAllProductsLocation()
    {
        return $this->createQueryBuilder("product")
            ->select()
            ->from("VelotnBundle:ProduitsLocation","plocation")
            ->innerJoin("plocation.id","pl")
            ->getQuery()
            ->execute();

    }

}