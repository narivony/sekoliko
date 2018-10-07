<?php

namespace App\Sekoliko\Service\UserBundle\Entity;

use App\Sekoliko\Service\MetierManagerBundle\Entity\SekolikoRole;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * User
 *
 * @ORM\Table(name="sekoliko_user", uniqueConstraints={@ORM\UniqueConstraint(name="username_canonical_UNIQUE", columns={"username_canonical"}), @ORM\UniqueConstraint(name="email_canonical_UNIQUE", columns={"email_canonical"}), @ORM\UniqueConstraint(name="confirmation_token_UNIQUE", columns={"confirmation_token"})})
 * @UniqueEntity(fields="email", message="Email déjà pris")
 * @UniqueEntity(fields="username", message="Identifiant déjà pris")
 * @ORM\Entity
 */
class User extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="usr_firstname", type="string", length=255, nullable=true)
     */
    private $usrFirstname;

    /**
     * @var string
     *
     * @ORM\Column(name="usr_lastname", type="string", length=255, nullable=true)
     */
    private $usrLastname;

    /**
     * @var string
     *
     * @ORM\Column(name="usr_address", type="string", length=255, nullable=true)
     */
    private $usrAddress;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="usr_date_create", type="datetime", nullable=true)
     */
    private $usrDateCreate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="usr_date_update", type="datetime", nullable=true)
     */
    private $usrDateUpdate;

    /**
     * @var string
     *
     * @ORM\Column(name="usr_phone", type="string", length=45, nullable=true)
     */
    private $usrPhone;

    /**
     * @var string
     *
     * @ORM\Column(name="usr_photo", type="string", length=255, nullable=true)
     */
    private $usrPhoto;

    /**
     * @var string
     *
     * @ORM\Column(name="usr_raison_sociale", type="string", length=255, nullable=true)
     */
    private $usrRaisonSociale;

    /**
     * @var string
     *
     * @ORM\Column(name="usr_color", type="string", length=10, options={"default":"#ff00ff"})
     */
    private $usrColor;


    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->usrDateCreate = new \DateTime();
    }

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
    public function getUsrFirstname()
    {
        return $this->usrFirstname;
    }

    /**
     * @param string $usrFirstname
     */
    public function setUsrFirstname($usrFirstname)
    {
        $this->usrFirstname = $usrFirstname;
    }

    /**
     * @return string
     */
    public function getUsrLastname()
    {
        return $this->usrLastname;
    }

    /**
     * @param string $usrLastname
     */
    public function setUsrLastname($usrLastname)
    {
        $this->usrLastname = $usrLastname;
    }

    /**
     * @return string
     */
    public function getUsrAddress()
    {
        return $this->usrAddress;
    }

    /**
     * @param string $usrAddress
     */
    public function setUsrAddress($usrAddress)
    {
        $this->usrAddress = $usrAddress;
    }

    /**
     * @return \DateTime
     */
    public function getUsrDateCreate()
    {
        return $this->usrDateCreate;
    }

    /**
     * @param \DateTime $usrDateCreate
     */
    public function setUsrDateCreate($usrDateCreate)
    {
        $this->usrDateCreate = $usrDateCreate;
    }

    /**
     * @return \DateTime
     */
    public function getUsrDateUpdate()
    {
        return $this->usrDateUpdate;
    }

    /**
     * @param \DateTime $usrDateUpdate
     */
    public function setUsrDateUpdate($usrDateUpdate)
    {
        $this->usrDateUpdate = $usrDateUpdate;
    }

    /**
     * @return string
     */
    public function getUsrPhone()
    {
        return $this->usrPhone;
    }

    /**
     * @param string $usrPhone
     */
    public function setUsrPhone($usrPhone)
    {
        $this->usrPhone = $usrPhone;
    }

    /**
     * @return string
     */
    public function getUsrPhoto()
    {
        return $this->usrPhoto;
    }

    /**
     * @param string $usrPhoto
     */
    public function setUsrPhoto($usrPhoto)
    {
        $this->usrPhoto = $usrPhoto;
    }

    /**
     * Get fullname
     *
     * @return string
     */
    public function getUsrFullname()
    {
        return $this->usrFirstname . ' ' . $this->usrLastname;
    }

    /**
     * @return string
     */
    public function getUsrRaisonSociale()
    {
        return $this->usrRaisonSociale;
    }

    /**
     * @param string $usrRaisonSociale
     */
    public function setUsrRaisonSociale($usrRaisonSociale)
    {
        $this->usrRaisonSociale = $usrRaisonSociale;
    }

    /**
     * @return string
     */
    public function getUsrColor()
    {
        return $this->usrColor;
    }

    /**
     * @param string $usrColor
     */
    public function setUsrColor($usrColor)
    {
        $this->usrColor = $usrColor;
    }

    /**
     * Get resume name
     *
     * @return string
     */
    public function getUsrResumeName()
    {
        return $this->usrFirstname . ' ' . substr($this->usrLastname, 0, 1) . '.';
    }

}
