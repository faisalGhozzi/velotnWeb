<?php
namespace VelotnBundle\Repository;
use Doctrine\ORM\EntityRepository;

class PiecesRechangesRepository extends EntityRepository
{


    public function findAllPieceRechanges()
    {
        return $this->createQueryBuilder("product")
            ->select()
            ->from("VelotnBundle:Piecesrechanges","piecer")
            ->innerJoin("piecer.id","pr")
            ->getQuery()
            ->execute();

    }











    
}