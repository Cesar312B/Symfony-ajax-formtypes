<?php

namespace App\Controller;

use App\Entity\Categoria;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Lista;
use App\Repository\ListaRepository;
use Doctrine\ORM\EntityManagerInterface;

class BackendListController extends AbstractController
{
    /**
     * @Route("/read_back", name="read_back")
     */
    public function readBack(ListaRepository $listaRepository): Response
    {
        $allTasks= $listaRepository->findAll();
        $jsonData = array();
        foreach ( $allTasks as $task) {
            $jsonData[]= array(
                'id'=> $task->getId(),
                'name'=> $task->getName(),
                'description'=> $task->getDescription(),
                'categoria' => $task->getCategoria()->getName(),
                'categoria_id'=> $task->getCategoria()->getId()
            );
        }

        return new JsonResponse($jsonData);
        
    }

    /**
     * @Route("/add_back", name="add_back")
     */
    public function add(Request $request,EntityManagerInterface $entityManager)
    {
    
        $name= $request->get('name');
        $description= $request->get('description');
        $categoria = $request->get('categoria');
        $c= $entityManager->getRepository(Categoria::class)->find($categoria);

        $msg= null; 
        if(isset($name) && trim($name) != ''&& 
           isset($description) && trim($description) != '' &&
           isset($categoria)  && trim($categoria) != ''
        ){
            $task= new Lista();
            $task->setName($name);
            $task->setDescription($description);
            $task->setCategoria($c);
            $entityManager->persist($task);
            $flush= $entityManager->flush();
            if($flush == null){
                $msg="Tarea agregada";
            }else{
                $msg="Errore en el envio de datos";
            }

        }else{
            $msg="Rellene los dos campos";
        }
        return new Response($msg);
    }


     /**
     * @Route("/edit_back", name="edit_back")
     */
    public function edit(Request $request,EntityManagerInterface $entityManager)
    {
        $data= $request->get('postData');
        $name= $data['name'];
        $description= $data['description'];
        $categoria= $data['categoria'];
        $id= $data['id'];
        $c= $entityManager->getRepository(Categoria::class)->find($categoria);
    
        $task= $entityManager->getRepository(Lista::class)->find($id);

            $task->setName($name);
            $task->setDescription($description);
            $task->setCategoria($c);
            $entityManager->persist($task);
            $flush= $entityManager->flush();
            if($flush == null){
                $msg="Tarea editada";
            }else{
                $msg="Errore en el envio de datos";
            }

        
        return new Response($msg);
    }


    /**
     * @Route("/delete_back", name="delete_back")
     */
    public function delete(Request $request): Response
    {
        $id= $request->get('id');
        $entityManager= $this->getDoctrine()->getManager();
        $task= $entityManager->getRepository(Lista::class)->find($id);
        $entityManager->remove($task);
        $flush= $entityManager->flush();
        
        if($flush == null){
            $msg="Tarea eliminada";
        }else{
            $msg="Errore en el envio de datos";
        }

    
    return new Response($msg);
        
    }

    /**
     * @Route("/search_back", name="search_back")
     */
    public function search(Request $request, ListaRepository $listaRepository): Response
    {
        $search= $request->get('search');
        $jsonData = array();

        if(isset($search) && trim($search))
        {
          $query= $listaRepository->createQueryBuilder('p')
          ->where('p.name LIKE :searchTerm OR p.description LIKE :searchTerm')
          ->setParameter('searchTerm', '%'.$search.'%')->getQuery()->execute();
          $idx= 0;
          foreach ($query as $task) {
            $temp= array(
                'id'=> $task->getId(),
                'name'=> $task->getName(),
                'description'=> $task->getDescription()

            );
            $jsonData[$idx++] = $temp;
          }
        }
        return new JsonResponse($jsonData);
    }

}
