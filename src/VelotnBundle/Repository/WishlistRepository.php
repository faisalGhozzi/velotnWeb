<?php

namespace VelotnBundle\Repository;

use Doctrine\ORM\EntityRepository;

class WishlistRepository extends EntityRepository{
    public function findByUser($user){
        return $this->createQueryBuilder("wishlist")
            ->join('wishlist.product',p)
            ->from('VelotnBundle:Produits','a')
            ->where('p.user = ?1')
            ->setParameter(1,$user)
            ->getQuery()
            ->getResult();
    }
}
