<?php
namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Element\File;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Form\Element\Select;

class DocumentoCreationForm extends Form
{
    /**
     * DocumentoCreationForm constructor.
     * @param null $name
     */
    public function __construct($name = null)
    {
        parent::__construct('create-documento');
        //Titolo
        $titolo = new Text();
        $titolo->setName("titolo");
        $titolo->setAttribute('placeholder', 'Titolo del documento');
        $titolo->setAttribute('class', 'form-control');
        $this->add($titolo);

        //filePath
        $filePath = new File();
        $filePath->setName("filePath");
        $filePath->setLabel("Seleziona il documento");
        $this->add($filePath);

        $argomento = new Select("select");
        $argomento->setName("select");
        $argomento->setLabel('Tipo di convenzione');
        $argomento->setAttribute('class', 'form-control');
        $argomento->setValueOptions(array());
        $this->add($argomento);

        //submit
        $btnSubmit = new Submit();
        $btnSubmit->setName("submit");
        $btnSubmit->setValue('Carica documento');
        $btnSubmit->setAttribute('id', 'btnSubmit');
        $btnSubmit->setAttribute('class', 'btn btn-primary');
        $this->add($btnSubmit);

        $this->setInputFilter($this->createInputFilter());

    }


    public function createInputFilter()
    {
        $inputFilter = new InputFilter();

        $inputFilter->add(
            [
                'name' => 'filePath',
                'required' => true,
                'filters' => [
                    [
                        'name' => 'FileRenameUpload',
                        'options' => [
                            'target' => 'data/documenti',
                            'randomize' => true,
                            'use_upload_name' => true
                        ]
                    ]
                ]
            ]
        );

        $inputFilter->add(
            [
                'name' => 'titolo',
                'required' => true,
                'validators' => [
                    [
                        'name' => 'Zend\I18n\Validator\Alnum',
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
