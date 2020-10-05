<?php

namespace Test\ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormError;

use Test\ClientBundle\Entity\Client;
use Test\ClientBundle\Form\ClientType;

use Test\ClientBundle\Entity\GroupClient;

class ClientController extends Controller
{
    public function indexAction(Request $request)
    {	
    	$searchQery = $request->get('query');

    	if(!empty($searchQery)){
    		$em = $this->getDoctrine()->getManager();
	        $dql = "SELECT c FROM TestClientBundle:Client c WHERE c.name like :name OR c.lastName like :lastname OR c.email like :email";
	        $clients = $em->createQuery($dql)
	        	->setParameter('name', '%'.$searchQery.'%')
	        	->setParameter('lastname', '%'.$searchQery.'%')
	        	->setParameter('email', '%'.$searchQery.'%')
	        ;
    	}
    	else{
    		$em = $this->getDoctrine()->getManager();
	        $dql = "SELECT c FROM TestClientBundle:Client c ORDER BY c.id DESC";
	        $clients = $em->createQuery($dql);
    	}

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
        	$clients, $request->query->getInt('page', 1),
        	5
        );

        $deleteFormAjax = $this->createCustomForm(':CLIENT_ID', 'DELETE', 'test_client_delete');

        return $this->render('TestClientBundle:Client:index.html.twig', array('pagination' => $pagination, 'delete_form_ajax' => $deleteFormAjax->createView()));
    }


    public function editAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
    	$client = $em->getRepository('TestClientBundle:Client')->find($id);

    	if(!$client){
    		throw $this->createNotFoundException('Cliente no encontrado');
    	}

    	$form = $this->createEditForm($client);

    	return $this->render('TestClientBundle:Client:edit.html.twig', array('client' =>$client, 'form'=>$form->createView()));
    }

    private function createEditForm(Client $entity)
    {
    	$form = $this->createForm(new ClientType(), $entity, array('action' => $this->generateUrl('test_client_update', array('id' => $entity->getId())), 'method' => 'PUT'));

    	return $form;
    }

    public function updateAction($id, Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	$client = $em->getRepository('TestClientBundle:Client')->find($id);

    	if(!$client){
    		throw $this->createNotFoundException('Cliente no encontrado');
    	}

    	$form = $this->createEditForm($client);
    	$form->handleRequest($request);

    	if($form->isSubmitted() && $form->isValid()){
    		$em->flush();
    	}
		return $this->redirectToRoute('test_client_index');
    	//return $this->render('TestClientBundle:Client:edit.html.twig', array('client' =>$client, 'form'=>$form->createView()));
    }

    public function addAction()
    {
    	$client = new Client();
    	$form = $this->createCreateForm($client);

    	return $this->render('TestClientBundle:Client:add.html.twig', array('form' => $form->createView()));
    }

    private function createCreateForm (Client $entity)
    {
    	$form = $this->createForm(new ClientType(), $entity, array(
    			'action' => $this->generateUrl('test_client_create'),
    			'method' => 'POST'
    		));

    	return $form;
    }

    public function createAction(Request $request)
    {
    	$client = new Client();
    	$form = $this->createCreateForm($client);
    	$form->handleRequest($request);

    	if($form->isValid()){
    		$em = $this->getDoctrine()->getManager();

    		//$em->addGroupclient($groupclient);

    		$em->persist($client);
    		$em->flush();

    		return $this->redirectToRoute('test_client_index');
    	}

    	return $this->render('TestClientBundle:Client:add.html.twig', array('form' => $form->createView()));
    }

    public function viewAction($id)
    {
    	$repo = $this->getDoctrine()->getRepository('TestClientBundle:Client');

    	$client = $repo->find($id);

    	if(!$client){
    		throw $this->createNotFoundException('Cliente no encontrado');
    	}

    	$deleteForm = $this->createCustomForm($client->getId(), 'DELETE', 'test_client_delete');

    	return $this->render('TestClientBundle:Client:view.html.twig', array('client' => $client, 'delete_form' => $deleteForm->createView()));
    }

    public function deleteAction(Request $request, $id)
    {
    	$em = $this->getDoctrine()->getManager();
    	$client = $em->getRepository('TestClientBundle:Client')->find($id);

    	if(!$client){
    		throw $this->createNotFoundException('Cliente no encontrado');
    	}

    	$allClient = $em->getRepository('TestClientBundle:Client')->findAll();
    	$countClients = count($allClient);

    	//$form = $this->createDeleteForm($client);
    	$form = $this->createCustomForm($client->getId(), 'DELETE', 'test_client_delete');
    	$form->handleRequest($request);

    	if($form->isSubmitted() && $form->isValid()){

    		if($request->isXMLHttpRequest()){
    			$res = $this->deleteClient($em, $client);

    			return new Response(
    				json_encode(array('removed' => $res['removed'], 'countClients' => $countClients)),
    					200,
    					array('Content-Type' => 'aplication/json')
    			);
    		}

    		$res = $this->deleteClient($em, $client);
    		return $this->redirectToRoute('test_client_index');
    	}
    }

    private function deleteClient($em, $client){
    	$em->remove($client);
    	$em->flush();

    	$removed = 1;

    	return array('removed' =>$removed);
    }

    private function createCustomForm($id, $method, $route)
    {
    	return $this->createFormBuilder()
    		->setAction($this->generateUrl($route, array('id' => $id)))
    		->setMethod($method)
    		->getForm();
    }

}