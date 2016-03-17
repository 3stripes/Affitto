<?php

namespace Application\Controller;

use Application\Form\CategoryCreationForm;
use Application\Entity\Category;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\ArrayAdapter;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;


class CategoryConvenzioneController extends AbstractActionController
{
    public function indexAction()
    {
        $viewModel = new ViewModel();
        $form = new CategoryCreationForm();

        // paginator
        /** @var Request $request */
        $request = $this->getRequest();
        $pageNumber = $request->getQuery('page', 1);

        /** @var EntityManager $em */
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        /** @var EntityRepository $documentsRepository */
        $documentsRepository = $em->getRepository('Application\Entity\Category');

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

        $category = new Category();
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

        $id= $request->getPost('id');
        $documentsRepository = $em->getRepository('Application\Entity\Category');
        /** @var \Application\Entity\Category $category */
        $category = $documentsRepository->find($id);
        $elencoCategorie = $documentsRepository->findAll();

        if (!$category) {
            return new ApiProblemResponse(new ApiProblem(400, 'Category not found'));
        }

        $convenzioneRepository = $em->getRepository('Application\Entity\Convenzione');

        /** @var \Application\Entity\Documento $documenti */
        $convenzioni = $convenzioneRepository->findByCategoria($category);

        if(count($convenzioni)>0){
            $this->flashMessenger()->addErrorMessage('Non puoi eliminare la categoria: ci sono ' . count($convenzioni) . ' convenzioni in questa categoria');
        }
        elseif(count($elencoCategorie)==1){
            $this->flashMessenger()->addErrorMessage('Impossibile eliminare l ultima categoria');
        }
        else{
            $em->remove($category);
            $em->flush();
        }

        return $jsonModel;
    }

}