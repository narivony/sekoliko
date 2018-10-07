<?php

namespace App\Sekoliko\Service\MetierManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * SekolikoHoraire
 *
 * @ORM\Table(name="sekoliko_horaire")
 * @ORM\Entity
 */
class SekolikoHoraire
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
     * @var \DateTime
     *
     * @ORM\Column(name="hr_date_debut_saison", type="datetime", nullable=true)
     */
    private $hrDateDebutSaison;

    /**
     * @var  \DateTime
     *
     * @ORM\Column(name="hr_date_fin_saison", type="datetime", nullable=true)
     */
    private $hrDateFinSaison;

    /**
     * @var  \DateTime
     *
     * @ORM\Column(name="hr_debut", type="time", nullable=true)
     */
    private $hrDebut;

    /**
     * @var  \DateTime
     *
     * @ORM\Column(name="hr_fin", type="time", nullable=true)
     */
    private $hrFin;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return \DateTime
     */
    public function getHrDateDebutSaison()
    {
        return $this->hrDateDebutSaison;
    }

    /**
     * @param \DateTime $hrDateDebutSaison
     */
    public function setHrDateDebutSaison( $hrDateDebutSaison)
    {
        $this->hrDateDebutSaison = $hrDateDebutSaison;
    }

    /**
     * @return \DateTime
     */
    public function getHrDateFinSaison()
    {
        return $this->hrDateFinSaison;
    }

    /**
     * @param \DateTime $hrDateFinSaison
     */
    public function setHrDateFinSaison( $hrDateFinSaison)
    {
        $this->hrDateFinSaison = $hrDateFinSaison;
    }

    /**
     * @return \DateTime
     */
    public function getHrDebut()
    {
        return $this->hrDebut;
    }

    /**
     * @param \DateTime $hrDebut
     */
    public function setHrDebut( $hrDebut)
    {
        $this->hrDebut = $hrDebut;
    }

    /**
     * @return \DateTime
     */
    public function getHrFin()
    {
        return $this->hrFin;
    }

    /**
     * @param \DateTime $hrFin
     */
    public function setHrFin( $hrFin)
    {
        $this->hrFin = $hrFin;
    }

    /**
     * @return string
     */
    public function getHrDuree()
    {
        return $this->hrDebut->diff($this->hrFin)->format("%H:%I");
    }


}
