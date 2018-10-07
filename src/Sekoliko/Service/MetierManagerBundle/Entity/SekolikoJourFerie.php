<?php

namespace App\Sekoliko\Service\MetierManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * SekolikoJourFerie
 *
 * @ORM\Table(name="sekoliko_jour_ferie")
 * @UniqueEntity(fields={"jrFerDate"}, message="Ce date existe déjà")
 * @ORM\Entity
 */
class SekolikoJourFerie
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="jr_fer_nom", type="string", length=45, nullable=true)
     */
    private $jrFerNom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="jr_fer_date", type="date", nullable=true)
     */
    private $jrFerDate;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getJrFerNom()
    {
        return $this->jrFerNom;
    }

    /**
     * @param string $jrFerNom
     */
    public function setJrFerNom($jrFerNom)
    {
        $this->jrFerNom = $jrFerNom;
    }

    /**
     * @return \DateTime
     */
    public function getJrFerDate()
    {
        return $this->jrFerDate;
    }

    /**
     * @param \DateTime $jrFerDate
     */
    public function setJrFerDate($jrFerDate)
    {
        $this->jrFerDate = $jrFerDate;
    }

}
