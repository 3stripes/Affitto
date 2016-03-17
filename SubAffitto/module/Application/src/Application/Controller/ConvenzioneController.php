<?php

namespace Application\Controller;

use Application\Entity\Convenzione;
use Application\Form\ConvenzioneCreationForm;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Zend\Http\Headers;
use Zend\Http\Request;
use Zend\Http\Response\Stream;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\ArrayAdapter;

class ConvenzioneController extends AbstractActionController
{
    public function indexAction()
    {
        $viewModel = new ViewModel();

        /** @var Request $request */
        $request = $this->getRequest();
        $pageNumber = $request->getQuery('page', 1);

        /** @var EntityManager $em */
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        /** @var EntityRepository $documentsRepository */
        $documentsRepository = $em->getRepository('Application\Entity\Convenzione');


        $convenzioni = $documentsRepository->findAll();

        $elencoDocumenti = new ArrayAdapter($convenzioni);
        $paginator = new Paginator($elencoDocumenti);

        $paginator->setCurrentPageNumber($pageNumber);
        $paginator->setItemCountPerPage(10);

        $viewModel->setVariable('convenzioni', $convenzioni);
        $viewModel->setVariable('paginator', $paginator);

        return $viewModel;
    }

    public function editAction()
    {
        $form = new ConvenzioneCreationForm();
        $id = $this->params('id');
        $form->getInputFilter()->get('filePath')->setRequired(false);
        /** @var EntityRepository $documentsRepository */
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        $documentsRepository = $em->getRepository('Application\Entity\Convenzione');
        /** @var \Application\Entity\Convenzione $convenzione */
        $convenzione = $documentsRepository->find($id);
        $pathFileOld = $convenzione->getAllegati();

        $form->setData(['nome' => $convenzione->getNome()]);
        $form->setData(['note' => $convenzione->getNote()]);
        $form->setData(['select' => $convenzione->getCategoria()->getId()-1]);
        $form->setData(['submit' => 'Modifica convenzione']);

        /** @var Request $request */
        $request = $this->getRequest();

        /** @var EntityManager $em */
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        /** @var EntityRepository $categoriesRepository */
        $categoriesRepository = $em->getRepository('Application\Entity\Category');
        $categories = $categoriesRepository->findAll();


        foreach ($categories as $category)  :
            $categorie[] = get_object_vars($category)['nome'];
        endforeach;

        $form->get('select')->setAttribute('options', $categorie);

        if ($request->isPost()) {

            $data = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );

            $form->setData($data);
            if ($form->isValid()) {
                $formData = $form->getData();
                $nome = $formData['nome'];
                $note = $formData['note'];
                $categoria = $formData['select'];
                $category = $categoriesRepository->find($categoria+1);

                $pathFile = $formData['filePath']['tmp_name'];

                $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

                $convenzione->setNome($nome);
                $convenzione->setNote($note);
                $convenzione->setCategoria($category);

                if (empty($pathFile) == false) {
                    $convenzione->setAllegati($pathFile);
                    unlink($pathFileOld);
                }


                $em->persist($convenzione);
                $em->flush();

                $this->flashMessenger()->addSuccessMessage('Convenzione modificata');
                return $this->redirect()->toRoute('convenzione');
            }

        }


        $viewModel = new ViewModel();
        $viewModel->setVariable('element', $convenzione);
        $viewModel->setVariable("form", $form);
        return $viewModel;
    }

    public function downloadAction()
    {
        $id = $this->params('id');
        /** @var EntityRepository $documentsRepository */
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        $documentsRepository = $em->getRepository('Application\Entity\Convenzione');
        /** @var \Application\Entity\Convenzione $convenzione */
        $convenzione = $documentsRepository->find($id);
        $file = $convenzione->getAllegati();
        $nome = $convenzione->getNomeAllegati();

        $response = new Stream();
        $response->setStream(fopen($file, 'r'));
        $response->setStatusCode(200);
        $response->setStreamName(basename($file));
        $headers = new Headers();
        $headers->addHeaders(array(
            'Content-Disposition' => 'attachment; filename="' . basename($nome) . '"',
            'Content-Type' => 'application/octet-stream',
            'Content-Length' => filesize($file),
            'Expires' => '@0',
            'Cache-Control' => 'must-revalidate',
            'Pragma' => 'public'
        ));
        $response->setHeaders($headers);
        return $response;
    }

    public function viewAction()
    {
        $viewModel = new ViewModel();
        $id = $this->params('id');
        /** @var EntityRepository $documentsRepository */
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        $documentsRepository = $em->getRepository('Application\Entity\Convenzione');
        /** @var \Application\Entity\Convenzione $convenzione */

        $convenzione = $documentsRepository->find($id);

        $viewModel->setVariable('convenzione', $convenzione);


        return $viewModel;
    }

    public function deleteAction()
    {
        $id = $this->params('id');
        /** @var EntityRepository $documentsRepository */
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        $documentsRepository = $em->getRepository('Application\Entity\Convenzione');
        /** @var \Application\Entity\Convenzione $convenzione */
        $convenzione = $documentsRepository->find($id);
        $file = $convenzione->getAllegati();
        $em->remove($convenzione);
        $em->flush();
        unlink($file);

        $this->flashMessenger()->addSuccessMessage('Convenzione eliminata');

        return $this->redirect()->toRoute('convenzione');

    }

    public function createAction()
    {
        $viewModel = new ViewModel();
        $form = new ConvenzioneCreationForm();
        /** @var Request $request */
        $request = $this->getRequest();

        /** @var EntityManager $em */
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        /** @var EntityRepository $categoriesRepository */
        $categoriesRepository = $em->getRepository('Application\Entity\Category');
        $categories = $categoriesRepository->findAll();


        foreach ($categories as $category)  :
            $categorie[] = get_object_vars($category)['nome'];
        endforeach;

        $form->get('select')->setAttribute('options', $categorie);

        if ($request->isPost()) {

            $data = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );

            $form->setData($data);
            if ($form->isValid()) {
                $formData = $form->getData();
                $nomeConvenzione = $formData['nome'];
                $note = $formData['note'];
                $argomento = $formData['select'];
                $category = $categoriesRepository->find($argomento+1);
                $pathAllegati = $formData['filePath']['tmp_name'];
                $nome = $formData['filePath']['name'];

                $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
                $convenzione = new Convenzione();
                $convenzione->setNome($nomeConvenzione);
                $convenzione->setNote($note);
                $convenzione->setCategoria($category);
                $convenzione->setAllegati($pathAllegati);
                $convenzione->setNomeAllegati($nome);

                $em->persist($convenzione);
                $em->flush();

                $this->flashMessenger()->addSuccessMessage('Convenzione creata');
                return $this->redirect()->toRoute('convenzione');

            }


        }

        $viewModel->setVariable("form", $form);

        return $viewModel;
    }


}