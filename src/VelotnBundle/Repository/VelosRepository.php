<?php
namespace VelotnBundle\Repository;
use Doctrine\ORM\EntityRepository;

class VelosRepository extends EntityRepository
{

    public function findAllVelos()
    {
        return $this->createQueryBuilder("product")
            ->select()
            ->from("VelotnBundle:Velos","velo")
            ->innerJoin("velo.id","v")
            ->getQuery()
            ->execute();

    }












}