<?php
namespace VelotnBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository{

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
            ->from("VelotnBundle:Velos","v")
            ->getQuery()
            ->execute();

    }

    public function findAllAccessoires()
    {
        return $this->createQueryBuilder("product")
            ->select()
            ->from("VelotnBundle:Accessoires","a")
            ->getQuery()
            ->execute();

    }

    public function findAllPieceRechanges()
    {
        return $this->createQueryBuilder("product")
            ->select()
            ->from("VelotnBundle:Piecesrechanges","pr")
            ->getQuery()
            ->execute();

    }

    public function findAllProductsLocation()
    {
        return $this->createQueryBuilder("product")
            ->select()
            ->from("VelotnBundle:ProduitsLocation","pl")
            ->getQuery()
            ->execute();

    }

}