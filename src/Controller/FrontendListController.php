<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Lista;
use App\Form\ListType;


class FrontendListController extends AbstractController
{
    /**
     * @Route("/", name="app_frontend_list")
     */
    public function index(): Response
    {
        return $this->render('frontend_list/index.html.twig', [
            'controller_name' => 'Lista',
        ]);
    }


    /**
     * @Route("/add_task", name="add_task")
     */
    public function add(): Response
    {
        $form= $this->createForm(ListType::class);
        return $this->render('frontend_list/add_task.html.twig', [
            'form'=> $form->createView()
        ]);
    }

     /**
     * @Route("/adit_task", name="edit_task")
     */
    public function adit(): Response
    {
        $form= $this->createForm(ListType::class);
        return $this->render('frontend_list/adit_task.html.twig', [
            'form'=> $form->createView()
        ]);
    }

    /**
     * @Route("/search_task", name="search_task")
     */
    public function search(): Response
    {
        return $this->render('frontend_list/search_task.html.twig');
    }

    /**
     * @Route("/read_task", name="read_task")
     */
    public function read(Request $request): Response
    {
        $name= $request->get('var1');
        $entityManager= $this->getDoctrine()->getManager();
        $tasks= $entityManager->getRepository(Lista::class)->findByName($name);

        if (empty($tasks)) {
            return new Response("El termino".$name."no fue encontrado en la base de datos");
        }else{
            foreach ($tasks as $task) {
                $task_list= array(
                   
                    'name'=> $task->getName(),
                    'description'=> $task->getDescription(),
                    'categoria'=> $task->getCategoria()->getName()
    
                );
              }

        }
        return $this->render('frontend_list/read_task.html.twig', [
           'task'=> $task_list
        ]);
    }
}
