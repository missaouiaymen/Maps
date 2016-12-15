<?php


namespace FS\PaysBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;



/**
 * @ORM\Table(name="drapeaux")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */


class drapeaux
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

     /**
      * @ORM\Column(name="url", type="string", length=255)
      */
    private $url;

     /**
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;

    /**
     * @var UploadedFile
     */

    public $file;

    public $tempFilename;


    public function setFile(UploadedFile $file)
    {
        $this->file = $file;
        if (null !== $this->url) {
            $this->tempFilename = $this->url;
            $this->url = null;
            $this->alt = null;
        }
    }


    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null === $this->file) {
            return;     }

        $this->url = $this->file->guessExtension();
        $this->alt = $this->file->getClientOriginalName();
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {

        if (null === $this->file) {
            return;
        }
        if (null !== $this->tempFilename) {
            $oldFile = $this->getUploadRootDir().'/'.$this->id.'.'.$this->tempFilename;
            if (file_exists($oldFile)) {
                unlink($oldFile);
            }
        }
        $this->file->move(
            $this->getUploadRootDir(),
            $this->id.'.'.$this->url
        );

    }

    /**
     * @ORM\PreRemove()
     */
    public function preRemoveUpload()
    {
        // On sauvegarde temporairement le nom du fichier, car il dépend de l'id
        $this->tempFilename = $this->getUploadRootDir().'/'.$this->id.'.'.$this->url;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        // En PostRemove, on n'a pas accès à l'id, on utilise notre nom sauvegardé
        if (file_exists($this->tempFilename)) {
            // On supprime le fichier
            unlink($this->tempFilename);
        }
    }

    public function getUploadDir()
    {
        // On retourne le chemin relatif vers l'image pour un navigateur
        return 'uploads/img';
    }

    public function getUploadRootDir()
    {
        // On retourne le chemin relatif vers l'image pour notre code PHP
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }
    public function getWebPath()
    {
        return $this->getUploadDir().'/'.$this->getId().'.'.$this->getUrl();
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
     * Set url
     * @param string $url
     * @return drapeaux
     */

    public function setUrl($url)

    {

        $this->url = $url;

        return $this;

    }

    /**

     * Get url

     *

     * @return string

     */

    public function getUrl()

    {

        return $this->url;

    }

    /**

     * Set alt

     *

     * @param string $alt

     * @return drapeaux

     */

    public function setAlt($alt)

    {

        $this->alt = $alt;

        return $this;

    }

    /**

     * Get alt

     *

     * @return string

     */

    public function getAlt()

    {

        return $this->alt;

    }

    /**

     * Get file

     *

     * @return string

     */

    public function getFile()

    {

        return $this->file;

    }

    /**

     * Set tempFilename

     *

     * @param string $tempFilename

     * @return drapeaux

     */

    public function setTempFilename($tempFilename)

    {

        $this->tempFilename = $tempFilename;

        return $this;

    }

    /**

     * Get tempFilename

     *

     * @return string

     */

    public function getTempFilename()

    {

        return $this->tempFilename;

    }

}