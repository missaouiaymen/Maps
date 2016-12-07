<?php

namespace FS\PaysBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="pays")
 * @ORM\Entity(repositoryClass="FS\PaysBundle\Entity\PaysRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 *         fields={"nom"},
 *         errorPath="nom",
 *         message="This pays is already in use on that host.")
 */
class Pays
{

    /**
     * @ORM\ManyToOne(targetEntity="FS\PaysBundle\Entity\Continent",inversedBy="pays")
     * @ORM\JoinColumn(nullable=false)
     */
    public $continent;

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
     * @ORM\Column(name="population", type="integer", unique=true)
     */
    public $population;


    public  $oldPopulation ;

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
     * @return Pays
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
     * @return Pays
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
     * Set continent
     *
     * @param \FS\PaysBundle\Entity\Continent $continent
     *
     * @return Pays
     */
    public function setContinent(\FS\PaysBundle\Entity\Continent $continent)
    {
        $this->continent = $continent;

        return $this;
    }

    /**
     * Get continent
     *
     * @return \FS\PaysBundle\Entity\Continent
     */
    public function getContinent()
    {
        return $this->continent;
    }


    /**
     * @ORM\PrePersist
     */
    public function increase()
    {
        $this->getContinent()->increaseContinent();
    }

    /**
     * @ORM\PreRemove
     */
    public function decrease()
    {
        $this->getContinent()->decreaseContinent();
    }

    /**
     * @ORM\PrePersist
     */
    public function increaseContinentPopulation()
    {
        $this->getContinent()->increasePopulation($this->population);
    }

    /**
     * @ORM\PreRemove
     */
    public function decreaseContinentPopulation(){
        $this->getContinent()->decreasePopulation($this->population);
    }

    public function getOldPopulation(){
        return $this->oldPopulation;
    }

    public  function setOldPopulation($pop){
        $this->oldPopulation = $pop;
    }
}

