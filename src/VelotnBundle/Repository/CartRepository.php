<?php
namespace VelotnBundle\Repository;
use Doctrine\ORM\EntityRepository;

class CartRepository extends EntityRepository{

    public function findByUser($user){
        return $this->createQueryBuilder("panier")
            ->select()
            ->from("VelotnBundle:Panier",'cart')
            ->from("VelotnBundle:Produits", 'a')
            ->innerJoin('cart.produit','a')
            ->where('cart.user = ?1')
            ->setParameter(1,$user)
            ->getQuery()
            ->execute();

    }
}