<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Documento
 *
 * @ORM\Table(name="documento")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Documento
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * @ORM\Column(name="Titolo", type="string", length=255, nullable=false)
     */
    private $titolo;

    /**
     * @ORM\Column(name="pathFile", type="string", length=255, nullable=false)
     */
    private $pathFile;

    /**
     * @ORM\Column(name="shortPathFile", type="string", length=255, nullable=false)
     */
    private $shortPathFile;

    /**
     * @ORM\ManyToOne(targetEntity="CategoryDocumenti", inversedBy="documents")
     * @ORM\JoinColumn(name="idCategoria", referencedColumnName="id")
     */
    private $categoria;

    /**
     * @ORM\Column(name="dataCreate", type="datetime", nullable=false)
     */
    private $dateCreate;

    /**
    * @ORM\Column(name="dataModified", type="datetime", nullable=false)
    */
   private $dataModified;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return CategoryDocumenti
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * @param CategoryDocumenti
     */
    public function setCategoria(CategoryDocumenti $categoria)
    {
        $this->categoria = $categoria;
    }

    /**
     * @return mixed
     */
    public function getShortPathFile()
    {
        return $this->shortPathFile;
    }

    /**
     * @param mixed $shortPathFile
     */
    public function setShortPathFile($shortPathFile)
    {
        $this->shortPathFile = $shortPathFile;
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
    public function getTitolo()
    {
        return $this->titolo;
    }

    /**
     * @param mixed $titolo
     */
    public function setTitolo($titolo)
    {
        $this->titolo = $titolo;
    }

    /**
     * @return mixed
     */
    public function getPathFile()
    {
        return $this->pathFile;
    }

    /**
     * @param mixed $pathFile
     */
    public function setPathFile($pathFile)
    {
        $this->pathFile = $pathFile;
    }

    /**
     * @return mixed
     */
    public function getDateCreate()
    {
        return $this->dateCreate;
    }

    /**
     * @param mixed $dateCreate
     */
    public function setDateCreate($dateCreate)
    {
        $this->dateCreate = $dateCreate;
    }

    /**
     * @return mixed
     */
    public function getDataModified()
    {
        return $this->dataModified;
    }

    /**
     * @param mixed $dataModified
     */
    public function setDataModified($dataModified)
    {
        $this->dataModified = $dataModified;
    }


    /** @ORM\PrePersist */
    public function prePersist()
    {
        $this->setDateCreate(new \DateTime());
        $this->setDataModified(new \DateTime());
    }

    /** @ORM\PreUpdate */
    public function preUpdate()
    {
        $this->setDataModified(new \DateTime());
    }
}