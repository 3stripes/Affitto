<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Category
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
     * @ORM\OneToMany(targetEntity="Convenzione", mappedBy="categoria")
     */
    private $convenzioni;

    /**
     * @ORM\Column(name="nome", type="string", length=255, nullable=false)
     */
    public $nome;

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
    public function getConvenzioni()
    {
        return $this->convenzioni;
    }

    /**
     * @param mixed $convenzioni
     */
    public function setConvenzioni($convenzioni)
    {
        $this->convenzioni = $convenzioni;
    }





}