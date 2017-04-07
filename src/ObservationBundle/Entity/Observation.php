<?php

namespace ObservationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use UserBundle\Entity\User;

/**
 * Observation
 *
 * @ORM\Table(name="observation")
 * @ORM\Entity(repositoryClass="ObservationBundle\Repository\ObservationRepository")
 */

class Observation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="date", type="datetime")
     */
    protected $date;

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="text")
     */
    private $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="text")
     */
    private $longitude;

    /**
     * @ORM\ManyToOne(targetEntity="Oiseau", inversedBy="observations")
     * @ORM\JoinColumn(name="oiseau_id", referencedColumnName="id")
     */
    protected $oiseau;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="observations")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\OneToOne(targetEntity="ObservationBundle\Entity\Image", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private $image;

    /**
     * @var boolean
     *
     * @ORM\Column(name="validated", type="boolean")
     */
    private $validated;

    public function __construct()
    {
        $this->date = new \DateTime();
        $this->validated = 0;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param string $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param string $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }


    /**
     * @return Oiseau
     */
    public function getOiseau()
    {
        return $this->oiseau;
    }

    /**
     * @param Oiseau $oiseau
     */
    public function setOiseau(Oiseau $oiseau)
    {
        $this->oiseau = $oiseau;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param Image $image
     */
    public function setImage(Image $image = null)
    {
        $this->image = $image;
    }

    /**
     * @return Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return boolean
     */
    public function isValidated()
    {
        return $this->validated;
    }

    /**
     * @param boolean $validated
     */
    public function setValidated($validated)
    {
        $this->validated = $validated;
    }


}