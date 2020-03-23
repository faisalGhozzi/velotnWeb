<?php

namespace VelotnBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @var string
     *
     * @ORM\Column(name="addresse", type="string", length=30, nullable=false)
     */
    private $addresse;

    /**
     * @return string
     */
    public function getAddresse()
    {
        return $this->addresse;
    }

    /**
     * @param string $addresse
     */
    public function setAddresse($addresse)
    {
        $this->addresse = $addresse;
    }

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}
