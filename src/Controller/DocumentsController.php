<?php

namespace App\Controller;

use App\Entity\Documents;
use App\Form\DocumentsType;
use App\Repository\DocumentsRepository;
use App\Entity\Roles;
use App\Repository\RolesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManager;
/**
 * @Route("/documents")
 */
class DocumentsController extends AbstractController
{
    /**
     * @Route("/", name="documents_index", methods="GET")
     */
    public function index(DocumentsRepository $documentsRepository): Response
    {
        return $this->render('documents/index.html.twig', ['documents' => $documentsRepository->findAll()]);
    }

    /**
     * @Route("/new", name="documents_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
//        $roles_list = array();
        $document = new Documents();
        $form = $this->createForm(DocumentsType::class, $document);
        $form->handleRequest($request);
//        $doc = new DocumentsRepository();
        $results = $this->getDoctrine()
        ->getRepository(Roles::class)->getRolesList();
//        $em = $this->getEntityManager();
/*        if ($em) {
	        $qb  = $this->createQueryBuilder();
			if ($qb) {
				$sub = $qb->select('id, role')
        		  ->from('Roles')
		          ->order('id', 'ASC');
			} else {
				$roles_list = 'no qb';
			}
  /*      } else {
				$roles_list = 'no em';
        }
        foreach($result as $id=>$role) {
			$roles_list[] = array($id => $role);
		}*/
		foreach($results as $result) {
//			foreach($result as $row) {
				$roles_list[] = array($result['id'] => $result['role']);
//			}
		}
//		$roles_list = $result;
        if ($form->isSubmitted() && $form->isValid()) {
        }

        return $this->render('documents/new.html.twig', [
            'document' => $document,
            'form' => $form->createView(),
            'roles_list' => $roles_list
        ]);
    }

    /**
     * @Route("/{id}", name="documents_show", methods="GET")
     */
    public function show(Documents $document): Response
    {
		$result = $this->DocumentAccessGranted($document->getId());
    if ($result) {
    return $this->render('documents/show.html.twig', ['document' => $document, 'user_id' => $result]);
    } else {
    return $this->render('documents/show.html.twig', ['error' => 'Cannot access that file']);
    }
        
    }

    /**
     * @Route("/{id}/edit", name="documents_edit", methods="GET|POST")
     */
    public function edit(Request $request, Documents $document): Response
    {
        $form = $this->createForm(DocumentsType::class, $document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('documents_index', ['id' => $document->getId()]);
        }

        return $this->render('documents/edit.html.twig', [
            'document' => $document,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="documents_delete", methods="DELETE")
     */
    public function delete(Request $request, Documents $document): Response
    {
        if ($this->isCsrfTokenValid('delete'.$document->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($document);
            $em->flush();
        }

        return $this->redirectToRoute('documents_index');
    }

 
	// We define the route using annotations
	/**
	 * @Route("/fileuploadhandler", name="fileuploadhandler")
	 */
	public function fileUploadHandler(Request $request) {
	    $output = array('uploaded' => false);
    	// get the file from the request object
	    $file = $request->files->get('file');
    	// generate a new filename (safer, better approach)
	    // To use original filename, $fileName = $this->file->getClientOriginalName();
    	$fileName = md5(uniqid()).'.'.$file->guessExtension();
 
	    // set your uploads directory
    	//$uploadDir = $this->get('kernel')->getRootDir() . '/../web/uploads/';
		$uploadDir = $this->getParameter('file_directory');
		error_log('$uploadDir'.$uploadDir);
		// . '/../web/uploads/';
		
	    if (!file_exists($uploadDir) && !is_dir($uploadDir)) {
    	    mkdir($uploadDir, 0775, true);
	    }
    	if ($file->move($uploadDir, $fileName)) { 
	       $output['uploaded'] = true;
    	   $output['fileName'] = $fileName;
    	   $output['uploadDir'] = $uploadDir;
	    }
	    $document = new Documents();
		$em = $this->getDoctrine()->getManager();
		$document->setDocumentName($fileName);
	    $document->setUploadName($uploadDir . $fileName);
    	$em->persist($document);
        $em->flush();
    	return new JsonResponse($output);
	}
	
	public function DocumentAccessGranted($document_id)
	{
	    $user_id = $this->getUser()->getId();
	    $em = $this->getDoctrine()->getManager();
	    
    	$sql = 'SELECT 1 FROM documents d 
    		INNER JOIN roles_users ru ON ru.id = d.fk_roles_users_id
    		INNER JOIN roles r ON r.id = ru.role_id
    		INNER JOIN users u ON u.id=ru.user_id' . 
    		' WHERE 
    		d.id = ' . $document_id . ' AND r.id = ru.role_id 
    		AND u.id = ' . $user_id;
		//create the prepared statement, by getting the doctrine connection
		$em = $this->getDoctrine()->getManager();
	    $stmt = $em->getConnection()->prepare($sql);
    	$stmt->execute();
	    $result = $stmt->fetch(\PDO::FETCH_COLUMN);
/*    foreach($results as $result) {
	    break;
    }*/
    	return $result;
	}

	public function showfile($id)
	{
		if ($this->DocumentAccessGranted($id)) {
		}
	}
}
