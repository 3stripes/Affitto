<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Documento
 *
 * @ORM\Table(name="news")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class News
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
     * @ORM\Column(name="Testo", type="string", length=255, nullable=false)
     */
    private $testo;
    /**
     * @ORM\Column(name="dataCreate", type="datetime", nullable=false)
     */
    private $dateCreate;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTesto()
    {
        return $this->testo;
    }

    /**
     * @param mixed $testo
     */
    public function setTesto($testo)
    {
        $this->testo = $testo;
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


}