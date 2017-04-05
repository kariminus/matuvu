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
     * @Assert\NotBlank()
     */
    private $firstname;

    /**
     * @ORM\Column(name="last_name", type="string")
     * @Assert\NotBlank()
     */
    private $lastname;

    /**
     * @ORM\Column(name="email", type="string", unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(name="postal_code", type="integer")
     * @Assert\NotBlank()
     */
    private $postalcode;

    /**
     *
     * @ORM\Column(name="password", type="string")
     */
    private $password;

    /**
     *
     * @var string
     * @Assert\NotBlank(groups={"Registration"})
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="json_array")
     */
    private $roles = [];

    /**
     * @ORM\OneToMany(targetEntity="ObservationBundle\Entity\Observation", mappedBy="oiseau")
     */
    protected $observations;

    public function __construct()
    {
        $this->observations = new ArrayCollection();
        $this->setRoles(['ROLE_PAR']);
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
    public function getPostalcode()
    {
        return $this->postalcode;
    }

    /**
     * @param int $postalcode
     */
    public function setPostalcode($postalcode)
    {
        $this->postalcode = $postalcode;
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
}