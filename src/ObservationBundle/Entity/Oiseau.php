<?php

namespace ObservationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Oiseau
 *
 * @ORM\Table(name="oiseau")
 * @ORM\Entity(repositoryClass="ObservationBundle\Repository\OiseauRepository")
 */
class Oiseau
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="scientific_name", type="string", length=255)
     */
    private $scientificName;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;


    /**
     * @var string
     *
     * @ORM\Column(name="ordre", type="string", length=255)
     */
    private $ordre;

    /**
     * @var string
     *
     * @ORM\Column(name="family", type="string", length=255)
     */
    private $family;

    /**
     * @Gedmo\Slug(fields={"scientificName"})
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;


    /**
     * @ORM\OneToMany(targetEntity="ObservationBundle\Entity\Observation", mappedBy="oiseau")
     */
    protected $observations;

    public function __construct()
    {
        $this->observations = new ArrayCollection();
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
    public function getScientificName()
    {
        return $this->scientificName;
    }

    /**
     * @param string $scientificName
     */
    public function setScientificName($scientificName)
    {
        $this->scientificName = $scientificName;
    }


    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getOrdre()
    {
        return $this->ordre;
    }

    /**
     * @param string $ordre
     */
    public function setOrdre($ordre)
    {
        $this->ordre = $ordre;
    }

    /**
     * @return string
     */
    public function getFamily()
    {
        return $this->family;
    }

    /**
     * @param string $family
     */
    public function setFamily($family)
    {
        $this->family = $family;
    }



    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
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