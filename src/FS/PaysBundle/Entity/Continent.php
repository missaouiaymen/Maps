<?php

namespace FS\PaysBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;




/**
 * Continent
 * @ORM\Table(name="continent")
 * @ORM\Entity(repositoryClass="FS\PaysBundle\Repository\PaysRepository")
 * @UniqueEntity(
 *         fields={"nom"},
 *         errorPath="nom",
 *         message="This Continent is already in use on that host."
 * )
 */
class Continent
{
    /**
     * @ORM\OneToMany(targetEntity="Pays",mappedBy ="continent", cascade={"remove"} )
     */
    private $pays;

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @ORM\Column(name="nom", type="string", length=255 ,unique=true)
     */
    public $nom;

    /**
     * @ORM\Column(name="population", type="integer")
     */
    public $population =0 ;

    /**
     * @ORM\Column(name="nbpays", type="integer")
     */
    public $nbPays = 0;

    public function increaseContinent()
    {
        $this->nbPays++;
    }

    public function decreaseContinent()
    {
        $this->nbPays--;

    }

    /**
     *
     */
    public function increasePopulation()
    {
        $this->population++;
    }

    public function decreasePopulation()
    {
        $this->population--;
    }


    public  function __construct()
    {
        $this->pays = new ArrayCollection();

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
     * Set nom
     *
     * @param string $nom
     *
     * @return Continent
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set population
     *
     * @param integer $population
     *
     * @return Continent
     */
    public function setPopulation($population)
    {
        $this->population = $population;

        return $this;
    }

    /**
     * Get population
     *
     * @return integer
     */
    public function getPopulation()
    {
        return $this->population;
    }

    /**
     * Set nbPays
     *
     * @param integer $nbPays
     *
     * @return Continent
     */
    public function setNbPays($nbPays)
    {
        $this->nbPays = $nbPays;

        return $this;
    }

    /**
     * Get nbPays
     *
     * @return integer
     */
    public function getNbPays()
    {
        return $this->nbPays;
    }

    /**
     * Add pays
     *
     * @param \FS\PaysBundle\Entity\Pays $pays
     *
     * @return Continent
     */
    public function addPays(\FS\PaysBundle\Entity\Pays $pays)
    {
        $this->pays[] = $pays;

        return $this;
    }

    /**
     * Remove pays
     *
     * @param \FS\PaysBundle\Entity\Pays $pays
     */
    public function removePays(\FS\PaysBundle\Entity\Pays $pays)
    {
        $this->pays->removeElement($pays);
    }

    /**
     * Get pays
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPays()
    {
        return $this->pays;
    }

}
