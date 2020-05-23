<?php
namespace VelotnBundle\Repository;
use Doctrine\ORM\EntityRepository;

class ProduitsLocationRepository extends EntityRepository
{


    /*public function findAllProductsLocation()
    {
        return $this->createQueryBuilder("product")
            ->select("")
            ->from("VelotnBundle:ProduitsLocation","plocation")
            ->from("VelotnBundle:Produits","u")
            ->innerJoin("plocation.id","pl")
            ->getQuery()
            ->execute();

    }*/
    public function findAllProductsLocation()
    {
        return $this->createQueryBuilder("product")
            ->select("")
            ->from("VelotnBundle:ProduitsLocation","plocation")
            ->from("VelotnBundle:Produits","u")
            ->innerJoin("plocation.id","pl")
            ->getQuery()
            ->getResult();

    }










    
}