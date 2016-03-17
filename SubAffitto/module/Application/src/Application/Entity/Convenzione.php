<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Convenzione
 *
 * @ORM\Table(name="convenzione")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Convenzione
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
     * @ORM\Column(name="nome", type="string", length=255, nullable=false)
     */
    private $nome;

    /**
     * @ORM\Column(name="note", type="string", length=255, nullable=false)
     */
    private $note;

    /**
     * @ORM\Column(name="allegati", type="string", length=255, nullable=false)
     */
    private $allegati;

    /**
     * @ORM\Column(name="nomeAllegati", type="string", length=255, nullable=false)
     */
    private $nomeAllegati;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="documents")
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
     * @return mixed
     */
    public function getNomeAllegati()
    {
        return $this->nomeAllegati;
    }

    /**
     * @param mixed $nomeAllegati
     */
    public function setNomeAllegati($nomeAllegati)
    {
        $this->nomeAllegati = $nomeAllegati;
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
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return mixed
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param mixed $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }

    /**
     * @return mixed
     */
    public function getAllegati()
    {
        return $this->allegati;
    }

    /**
     * @param mixed $allegati
     */
    public function setAllegati($allegati)
    {
        $this->allegati = $allegati;
    }

    /**
     * @return Category
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * @param Category
     */
    public function setCategoria(Category $categoria)
    {
        $this->categoria = $categoria;
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