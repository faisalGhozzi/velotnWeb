<?php
namespace VelotnBundle\Repository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;

class CartRepository extends EntityRepository{

    public function findByUser($user){
        return $this->createQueryBuilder("panier")
            ->join('panier.produit',p)
            ->addSelect('a')
            ->from('VelotnBundle:Produits','a')
            ->where('p.user = ?1')
            ->setParameter(1,$user)
            ->getQuery()
            ->getResult();

    }
}