<?php
// src/Controller/UploadController.php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


class UploadController extends AbstractController
{
	/**
     * @Route("/lucky/number")
     */
    public function number()
    {
        $number = random_int(0, 100);

        return $this->render('lucky/number.html.twig', [
            'number' => $number,
        ]);
    }

	/**
	* @Route("/api/uploadfile")
	* Method("POST")
	*/
	public function uploadAction(Request $request) {
	    try {
        	$file = $request->files->get ( 'my_file' );
        	if (is_object($file)) {
	        	$fileName = md5 ( uniqid () ) . '.' . $file->guessExtension ();
		        $original_name = $file->getClientOriginalName ();
        		$file->move ( $this->container->getParameter ( 'file_directory' ), $fileName );
    	    	$file_entity = new UploadedFile ();
		        $file_entity->setFileName ( $fileName );
    	    	$file_entity->setActualName ( $original_name );
    		    $file_entity->setCreated ( new \DateTime () );
            
	        	$manager = $this->getDoctrine ()->getManager ();
	        	$manager->persist ( $file_entity );
    		    $manager->flush ();
	    	    $array = array (
        		    'status' => 1,
    	        	'file_id' => $file_entity->getFileId () 
		        );
        	} else {
        		    	    $array = array (
        		    'status' => 0);
        	}
            $response = new JsonResponse ( $array, 200 );
        	return $response;
	    } catch ( Exception $e ) {
    	    $array = array('status'=> 0 );
	        $response = new JsonResponse($array, 400);
        	return $response;
    	}
	}

	/**
	* @Route("/api/downloadfile/{id}")
	*/
	public function downloadAction($id) {
    	try {
        	$file = $this->getDoctrine ()->getRepository ( 'AppBundle:UploadedFile' )->find ( $id );
	        if (! $file) {
    	        $array = array (
        	        'status' => 0,
            	    'message' => 'File does not exist' 
	            );
    	        $response = new JsonResponse ( $array, 200 );
        	    return $response;
	        }
    	    $displayName = $file->getActualName ();
        	$fileName = $file->getFileName ();
	        $file_with_path = $this->container->getParameter ( 'file_directory' ) . "/" . $fileName;
    	    $response = new BinaryFileResponse ( $file_with_path );
        	$response->headers->set ( 'Content-Type', 'text/plain' );
	        $response->setContentDisposition ( ResponseHeaderBag::DISPOSITION_ATTACHMENT, $displayName );
    	    return $response;
	    } catch ( Exception $e ) {
    	    $array = array (
        	    'status' => 0,
            	'message' => 'Download error' 
	        );
    	    $response = new JsonResponse ( $array, 400 );
        	return $response;
    }
}
}