<?php
namespace VelotnBundle\Repository;
use Doctrine\ORM\EntityRepository;

class AccessoiresRepository extends EntityRepository
{



    public function findAllAccessoires()
    {
        return $this->createQueryBuilder("product")
            ->select()
            ->from("VelotnBundle:Accessoires","acc")
            ->innerJoin("acc.id","a")
            ->getQuery()
            ->getResult();

    }









    
}