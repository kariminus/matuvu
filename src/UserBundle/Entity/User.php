<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ObservationBundle\Entity\Observation;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="Ce mail est déjà utilisé")
 * @ORM\HasLifecycleCallbacks()
 */
class User implements UserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="first_name", type="string")
     * @Assert\NotBlank(message="Saisissez un prénom")
     */
    private $firstname;

    /**
     * @ORM\Column(name="last_name", type="string")
     * @Assert\NotBlank(message="Saisissez un nom")
     */
    private $lastname;

    /**
     * @ORM\Column(name="email", type="string", unique=true)
     * @Assert\NotBlank(message="Saisissez un email")
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(name="postal_code", type="integer", nullable=true)
     */
    private $postalCode;

    /**
     *
     * @ORM\Column(name="password", type="string")
     */
    private $password;

    /**
     *
     * @var string
     * @Assert\NotBlank(groups={"Registration"}, message="Saisissez un mot de passe")
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="json_array")
     */
    private $roles = [];

    /**
     * @ORM\OneToMany(targetEntity="ObservationBundle\Entity\Observation", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $observations;


    /**
     * @var int
     * @ORM\Column(name="observations_number", type="integer")
     */
    private $observationsNumber;

    public function __construct()
    {
        $this->observations = new ArrayCollection();
        $this->setRoles(['ROLE_PAR']);
        $this->setObservationsNumber(0);
    }

    public function getUsername()
    {
        return $this->email;
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
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }


    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return int
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @param int $postalCode
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
    }


    public function getRoles()
    {
        $roles = $this->roles;
        if (!in_array('ROLE_PAR', $roles)) {
            $roles[] = 'ROLE_PAR';
        }
        return $roles;
    }

    public function setRoles(array $roles)
    {
        $this->roles = $roles;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
        $this->password = null;
    }

    public function getSalt()
    {
    }

    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    /**
     * Add observations
     *
     * @param Observation $observations
     */
    public function addObservation(Observation $observations)
    {
        $this->observations[] = $observations;
    }

    /**
     * @param Observation $observation
     */
    public function removeObservation(Observation $observation)
    {
        $this->observations->removeElement($observation);
    }
    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getObservations()
    {
        return $this->observations;
    }

    /**
     * @return int
     */
    public function getObservationsNumber()
    {
        return $this->observationsNumber;
    }

    /**
     * @param int $observationsNumber
     */
    public function setObservationsNumber($observationsNumber)
    {
        $this->observationsNumber = $observationsNumber;
    }

    /**
     * @param int $observationsNumber
     */
    public function addObservationsNumber()
    {
        $this->observationsNumber ++;
    }
}