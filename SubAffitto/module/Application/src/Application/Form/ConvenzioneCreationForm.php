<?php
namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Element\File;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Element\Select;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;


class ConvenzioneCreationForm extends Form
{
    /**
     * ConvenzioneCreationForm constructor.
     * @param null $name
     */
    public function __construct($name = null)
    {
        parent::__construct('create-convenzione');
        // Nome convenzione
        $nome = new Text();
        $nome->setName("nome");
        $nome->setAttribute('placeholder', 'Nome della convenzione');
        $nome->setAttribute('class', 'form-control');
        $this->add($nome);

        // note
        $note = new Textarea();
        $note->setName("note");
        $note->setAttribute('placeholder', 'Note della convenzione');
        $note->setAttribute('class', 'form-control');
        $note->setAttribute('ROWS', '6');
        $note->setAttribute('COLS', '100');
        $this->add($note);

        //select argomento convenzione

        $argomento = new Select("select");
        $argomento->setName("select");
        $argomento->setLabel('Tipo di convenzione');
        $argomento->setAttribute('class', 'form-control');
        $argomento->setValueOptions(array());
        $this->add($argomento);

        //filePath
        $filePath = new File();
        $filePath->setName("filePath");
        $filePath->setLabel("Seleziona il documento");
        $this->add($filePath);

        //submit
        $btnSubmit = new Submit();
        $btnSubmit->setName("submit");
        $btnSubmit->setValue('Carica convenzione');
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
                            'target' => 'data/allegati_convenzioni',
                            'randomize' => true,
                            'use_upload_name' => true
                        ]
                    ]
                ]
            ]
        );

        $inputFilter->add(
            [
                'name' => 'nome',
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
