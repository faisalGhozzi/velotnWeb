<?php
namespace VelotnBundle\Repository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;

class CartRepository extends EntityRepository{

    public function findByUser($user){
        return $this->createQueryBuilder("panier")
            ->select()
            ->from("VelotnBundle:Panier",'cart')
            ->from("VelotnBundle:Produits", 'a')
            ->innerJoin('a.id','r', Join::ON,'cart.produit_id=a.id')
            ->where('cart.user = ?1')
            ->setParameter(1,$user)
            ->getQuery()
            ->execute();

    }
}