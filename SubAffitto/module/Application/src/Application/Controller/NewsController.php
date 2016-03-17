<?php

namespace Application\Controller;

use Application\Entity\News;
use Application\Form\NewsCreationForm;
use Doctrine\ORM\EntityManager;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;
use Zend\Paginator\Paginator;
use Doctrine\ORM\EntityRepository;
use Zend\Paginator\Adapter\ArrayAdapter;


class NewsController extends AbstractActionController
{
    public function indexAction()
    {
        $viewModel = new ViewModel();
        $form = new NewsCreationForm();
        /** @var Request $request */
        $request = $this->getRequest();
        $pageNumber = $request->getQuery('page', 1);

        /** @var EntityManager $em */
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        /** @var EntityRepository $documentsRepository */
        $documentsRepository = $em->getRepository('Application\Entity\News');

        $category = $documentsRepository->findAll();

        $elencoCategorie = new ArrayAdapter($category);
        $paginator = new Paginator($elencoCategorie);

        $paginator->setCurrentPageNumber($pageNumber);
        $paginator->setItemCountPerPage(10);


        $viewModel->setVariable('paginator', $paginator);

        $viewModel->setVariable("form", $form);
        return $viewModel;
    }

    public function createAction()
    {
        $viewModel = new ViewModel();
        $form = new NewsCreationForm();
        /** @var Request $request */
        $request = $this->getRequest();

        if ($request->isPost()) {

            $data = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );

            $form->setData($data);
            if ($form->isValid()) {
                $formData = $form->getData();
                $titolo = $formData['titolo'];
                $testo = $formData['testo'];
                $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
                $news = new News();
                var_dump($testo);
                $news->setTitolo($titolo);
                $news->setTesto($testo);
                $em->persist($news);
                $em->flush();

                $this->flashMessenger()->addSuccessMessage('news salvata');
                return $this->redirect()->toRoute('news');
            }
        }
        $viewModel->setVariable("form", $form);
        return $viewModel;
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
        $documentsRepository = $em->getRepository('Application\Entity\News');
        /** @var \Application\Entity\Category $category */
        $category = $documentsRepository->find($id);
        $em->remove($category);
        $em->flush();

        return $jsonModel;
    }

    public function viewAction()
    {
        $viewModel = new ViewModel();
        $id = $this->params('id');
        /** @var EntityRepository $documentsRepository */
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        $documentsRepository = $em->getRepository('Application\Entity\News');
        /** @var \Application\Entity\News $news */
        $news = $documentsRepository->find($id);

        $viewModel->setVariable('news', $news);
        return $viewModel;

    }
}