<?php

namespace Application\Controller;

use Application\Entity\Documento;
use Application\Form\DocumentoCreationForm;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Zend\Http\Headers;
use Zend\Http\Request;
use Zend\Http\Response\Stream;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\ArrayAdapter;

class DocumentoController extends AbstractActionController
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
        $documentsRepository = $em->getRepository('Application\Entity\Documento');

        $documenti = $documentsRepository->findAll();

        $elencoDocumenti = new ArrayAdapter($documenti);
        $paginator = new Paginator($elencoDocumenti);

        $paginator->setCurrentPageNumber($pageNumber);
        $paginator->setItemCountPerPage(10);

        $viewModel->setVariable('documenti', $documenti);
        $viewModel->setVariable('paginator', $paginator);

        return $viewModel;
    }

    /**
     * @return ViewModel
     */
    public function createAction()
    {
        $viewModel = new ViewModel();
        $form = new DocumentoCreationForm();

        /** @var Request $request */
        $request = $this->getRequest();

        /** @var EntityManager $em */
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        /** @var EntityRepository $categoriesRepository */
        $categoriesRepository = $em->getRepository('Application\Entity\CategoryDocumenti');
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
                $titolo = $formData['titolo'];
                $pathFile = $formData['filePath']['tmp_name'];
                $shortPathFile = $formData['filePath']['name'];
                $argomento = $formData['select'];
                $categoria = $categoriesRepository->find($argomento+1);

                $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
                $documento = new Documento();
                $documento->setTitolo($titolo);
                $documento->setPathFile($pathFile);
                $documento->setShortPathFile($shortPathFile);
                $documento->setCategoria($categoria);
                $em->persist($documento);
                $em->flush();

                $this->flashMessenger()->addSuccessMessage('Documento creato');
                return $this->redirect()->toRoute('documento');
            }


        }
        $viewModel->setVariable("form", $form);
        return $viewModel;

    }

    public function downloadAction()
    {
        $id = $this->params('id');
        /** @var EntityRepository $documentsRepository */
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        $documentsRepository = $em->getRepository('Application\Entity\Documento');
        /** @var \Application\Entity\Documento $documento */
        $documento = $documentsRepository->find($id);
        $file = $documento->getPathFile();
        $nome = $documento->getShortPathFile();

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

    public function deleteAction()
    {
        $id = $this->params('id');
        /** @var EntityRepository $documentsRepository */
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        $documentsRepository = $em->getRepository('Application\Entity\Documento');
        /** @var \Application\Entity\Documento $documento */
        $documento = $documentsRepository->find($id);
        $file = $documento->getPathFile();
        $em->remove($documento);
        $em->flush();
        unlink($file);

        $this->flashMessenger()->addSuccessMessage('Documento eliminato');

        return $this->redirect()->toRoute('documento');

    }

    /**
     * @return \Zend\Http\Response|ViewModel
     */
    public function editAction()
    {
        $form = new DocumentoCreationForm();
        $form->getInputFilter()->get('filePath')->setRequired(false);
        $id = $this->params('id');
        /** @var EntityRepository $documentsRepository */
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        $documentsRepository = $em->getRepository('Application\Entity\Documento');
        /** @var \Application\Entity\Documento $documento */
        $documento = $documentsRepository->find($id);
        $pathFileOld = $documento->getPathFile();

        $form->setData(['titolo' => $documento->getTitolo()]);
        $form->setData(['select' => $documento->getCategoria()->getId()-1]);
        $form->setData(['submit' => 'Modifica documento']);

        /** @var Request $request */
        $request = $this->getRequest();

        /** @var EntityManager $em */
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        /** @var EntityRepository $categoriesRepository */
        $categoriesRepository = $em->getRepository('Application\Entity\CategoryDocumenti');
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
                $titolo = $formData['titolo'];
                $pathFile = $formData['filePath']['tmp_name'];
                $argomento = $formData['select'];
                $categoria = $categoriesRepository->find($argomento+1);
                $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

                $documento->setTitolo($titolo);
                $documento->setCategoria($categoria);

                if(empty($pathFile)==false){
                    $documento->setPathFile($pathFile);
                    unlink($pathFileOld);
                }

                $em->persist($documento);
                $em->flush();

                $this->flashMessenger()->addSuccessMessage('Documento modificato');
                return $this->redirect()->toRoute('documento');
            }

        }


        $viewModel = new ViewModel();
        $viewModel->setVariable('element', $documento);
        $viewModel->setVariable("form", $form);
        return $viewModel;
    }
}