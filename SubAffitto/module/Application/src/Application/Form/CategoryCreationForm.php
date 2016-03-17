<?php
namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Form;

class CategoryCreationForm extends Form
{
    /**
     * CategoryCreationForm constructor.
     * @param null $name
     */
    public function __construct($name = null)
    {
        parent::__construct('create-convenzione');
        $nome = new Text();
        $nome->setName("nome");
        $nome->setAttribute('placeholder', 'Nome della categoria');
        $nome->setAttribute('id', 'text-nome');
        $nome->setAttribute('class', 'form-control');
        $this->add($nome);

        $btnSubmit = new Submit();
        $btnSubmit->setName("submit");
        $btnSubmit->setValue('Aggiungi categoria');
        $btnSubmit->setAttribute('id', 'category-creation-add-category');
        $btnSubmit->setAttribute('class', 'btn btn-primary');
        $this->add($btnSubmit);


    }

}
