<?php
namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
class NewsCreationForm extends Form
{
    /**
     * NewsCreationForm constructor.
     * @param null $name
     */
    public function __construct($name = null)
    {
        parent::__construct('NEWS ');
        $titolo = new Text();
        $titolo->setName("titolo");
        $titolo->setAttribute('placeholder', 'Titolo della news');
        $titolo->setAttribute('id', 'titolo');
        $titolo->setAttribute('class', 'form-control');
        $this->add($titolo);

        $testo = new Textarea();
        $testo->setName("testo");
        $testo->setAttribute('placeholder', 'Testo');
        $testo->setAttribute('id', 'testo');
        $testo->setAttribute('class', 'form-control');
        $this->add($testo);

        $btnSubmit = new Submit();
        $btnSubmit->setName("submit");
        $btnSubmit->setValue('Salva');
        $btnSubmit->setAttribute('class', 'btn btn-primary ');
        $this->add($btnSubmit);
        $this->setInputFilter($this->createInputFilter());
    }
    public function createInputFilter()
    {
        $inputFilter = new InputFilter();
        $inputFilter->add(
            [
                'name' => 'titolo',
                'required' => true,
                'validators' => [
                    [
                        'name' => 'Zend\I18n\Validator\Alpha',
                        'options' => [
                            'allowWhiteSpace' => true,
                        ],
                    ]
                ],
            ]
        );


        $inputFilter->add(
            [
                'name' => 'testo',
                'required' => true,
                'validators' => [
                    [
                        'name' => 'Zend\Validator\NotEmpty',
                        'options' => [
                            'allowWhiteSpace' => true,
                        ],
                    ]
                ],
            ]
        );

        return $inputFilter;
    }
}
