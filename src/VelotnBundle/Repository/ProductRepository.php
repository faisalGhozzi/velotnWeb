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








}