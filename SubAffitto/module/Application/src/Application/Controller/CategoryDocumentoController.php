<?php

namespace Application\Controller;

use Application\Entity\CategoryDocumenti;
use Application\Form\CategoryCreationForm;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Paginator\Paginator;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;

class CategoryDocumentoController extends AbstractActionController
{
    public function indexAction()
    {
        $viewModel = new ViewModel();
        $form = new CategoryCreationForm();

        /** @var Request $request */
        $request = $this->getRequest();
        $pageNumber = $request->getQuery('page', 1);

        /** @var EntityManager $em */
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        /** @var EntityRepository $documentsRepository */
        $documentsRepository = $em->getRepository('Application\Entity\CategoryDocumenti');

        $category = $documentsRepository->findAll();

        $elencoCategorie = new ArrayAdapter($category);
        $paginator = new Paginator($elencoCategorie);

        $paginator->setCurrentPageNumber($pageNumber);
        $paginator->setItemCountPerPage(10);

        $viewModel->setVariable("form", $form);
        $viewModel->setVariable('categorie', $category);
        $viewModel->setVariable('paginator', $paginator);
        return $viewModel;
    }

    public function saveAction()
    {
        $jsonModel = new JsonModel();
        /** @var Request $request */
        $request = $this->getRequest();
        if (!$request->isPost()) {
            return new ApiProblemResponse(new ApiProblem(405, 'Method Not Allowed'));
        }

        /** @var EntityManager $em */
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        $category = new CategoryDocumenti();
        $nome = $request->getPost('nome');
        $category->setNome($nome);
        $em->persist($category);
        $em->flush();
        $jsonModel->setVariable('Form', $this);
        return $jsonModel;
    }

    public function deleteAction()
    {
        $jsonModel = new JsonModel();


        /** @var Request $request */
        $request = $this->getRequest();
        if (!$request->isPost()) {
            return new ApiProblemResponse(new ApiProblem(405, 'Method Not Allowed'));
        }

        /** @var EntityManager $em */
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        $id = $request->getPost('id');

        $categoriesRepository = $em->getRepository('Application\Entity\CategoryDocumenti');

        /** @var \Application\Entity\CategoryDocumenti $category */
        $category = $categoriesRepository->find($id);
        $elencoCategorie = $categoriesRepository->findAll();

        if (!$category) {
            return new ApiProblemResponse(new ApiProblem(400, 'Category not found'));
        }


        $documentsRepository = $em->getRepository('Application\Entity\Documento');

        /** @var \Application\Entity\Documento $documenti */
        $documenti = $documentsRepository->findByCategoria($category);



        if(count($documenti)>0){
            $this->flashMessenger()->addErrorMessage('Impossibile eliminare la categoria : ci sono ' . count($documenti) . ' documenti con questa categoria' );
        }
        else if (count($elencoCategorie)==1){
            $this->flashMessenger()->addErrorMessage('Impossibile eliminare l ultima categoria');
        }
        else{
            $em->remove($category);
            $em->flush();
        }


        return $jsonModel;
    }

}